<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider\Parser;

use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToParseFacultiesFetchedDataException;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;
use PHPHtmlParser\Dom;
use Exception;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFacultyBuilder;
use App\Services\MitsoService\MitsoFacultiesProvider\BaseMitsoFacultyBuilder;
use PHPHtmlParser\Dom\AbstractNode;

class HtmlMitsoFacultiesParser implements MitsoFacultiesParser
{
    private const FACULTIES_SELECTOR = '#fak_select option';

    /**
     * @var MitsoFacultyBuilder $facultyBuilder
     */
    private $facultyBuilder;

    /**
     * HtmlMitsoFacultiesParser constructor.
     * @param MitsoFacultyBuilder $builder
     */
    public function __construct(MitsoFacultyBuilder $builder = null)
    {
        $this->facultyBuilder = $builder ?? $this->getDefaultFacultyBuilder();
    }


    /**
     * Parse html of faculties.
     * @param string $html of faculties
     * @return MitsoFaculty[] faculties available on current or next week
     * @throws FailedToParseFacultiesFetchedDataException when failed to parse data
     */
    public function parse(string $html): array
    {
        try {
            $dom = new Dom();
            $dom->loadStr($html);
            $faculties = $dom->find(self::FACULTIES_SELECTOR);

            return array_map(function (AbstractNode $facultyNode) {
                return $this->facultyBuilder->withName($facultyNode->getAttribute('value'))->withTitle($facultyNode->text())->build();
            }, $faculties->toArray());
        } catch(Exception $e) {
            throw new FailedToParseFacultiesFetchedDataException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create default faculty instance.
     * @return MitsoFacultyBuilder instance of default faculty builder
     */
    private function getDefaultFacultyBuilder(): MitsoFacultyBuilder
    {
        return new BaseMitsoFacultyBuilder();
    }
}

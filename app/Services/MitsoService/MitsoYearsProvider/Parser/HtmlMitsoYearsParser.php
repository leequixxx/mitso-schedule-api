<?php


namespace App\Services\MitsoService\MitsoYearsProvider\Parser;

use App\Services\MitsoService\MitsoYearsProvider\MitsoYearBuilder;
use App\Services\MitsoService\MitsoYearsProvider\BaseMitsoYearBuilder;
use App\Services\MitsoService\MitsoYearsProvider\MitsoYear;
use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToParseYearsFetchedDataException;
use PHPHtmlParser\Dom;
use Exception;
use PHPHtmlParser\Dom\AbstractNode;

class HtmlMitsoYearsParser implements MitsoYearsParser
{
    private const YEARS_SELECTOR = 'option';

    /**
     * @var MitsoYearBuilder $yearBuilder
     */
    private $yearBuilder;

    /**
     * HtmlMitsoYearsParser constructor.
     * @param MitsoYearBuilder $builder
     */
    public function __construct(MitsoYearBuilder $builder = null)
    {
        $this->yearBuilder = $builder ?? $this->getDefaultYearBuilder();
    }

    /**
     * Parse html of years.
     * @param string $html of years
     * @return MitsoYear[] available on current or next week
     * @throws FailedToParseYearsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array
    {
        try {
            $dom = new Dom();
            $dom->loadStr($html);
            $faculties = $dom->find(self::YEARS_SELECTOR);

            return array_map(function (AbstractNode $facultyNode) {
                $number = $facultyNode->text();
                $number = explode(' ', $number)[0];

                return $this->yearBuilder->withName($facultyNode->getAttribute('value'))->withNumber($number)->build();
            }, $faculties->toArray());
        } catch(Exception $e) {
            throw new FailedToParseYearsFetchedDataException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create default year builder instance.
     * @return MitsoYearBuilder instance of default year builder
     */
    private function getDefaultYearBuilder(): MitsoYearBuilder
    {
        return new BaseMitsoYearBuilder();
    }
}

<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider\Parser;

use PHPHtmlParser\Dom;
use Exception;
use PHPHtmlParser\Dom\AbstractNode;
use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToParseStudyModelsFetchedDataException;
use App\Services\MitsoService\MitsoStudyModelsProvider\MitsoStudyModelBuilder;
use App\Services\MitsoService\MitsoStudyModelsProvider\BaseMitsoStudyModelBuilder;
use App\Services\MitsoService\MitsoStudyModelsProvider\MitsoStudyModel;

class HtmlMitsoStudyModelsParser implements MitsoStudyModelsParser
{
    private const STUDY_MODELS_SELECTOR = 'option';

    /**
     * @var MitsoStudyModelBuilder $studyModelBuilder
     */
    private $studyModelBuilder;

    /**
     * HtmlMitsoStudyModelsParser constructor.
     * @param MitsoStudyModelBuilder $builder
     */
    public function __construct(MitsoStudyModelBuilder $builder = null)
    {
        $this->studyModelBuilder = $builder ?? $this->getDefaultStudyModelBuilder();
    }


    /**
     * Parse html of study models.
     * @param string $html of study models
     * @return MitsoStudyModel[] study models available on current or next week
     * @throws FailedToParseStudyModelsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array
    {
        try {
            $dom = new Dom();
            $dom->loadStr($html);
            $faculties = $dom->find(self::STUDY_MODELS_SELECTOR);

            return array_map(function (AbstractNode $facultyNode) {
                return $this->studyModelBuilder->withName($facultyNode->getAttribute('value'))->withTitle($facultyNode->text())->build();
            }, $faculties->toArray());
        } catch(Exception $e) {
            throw new FailedToParseStudyModelsFetchedDataException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create default study model instance.
     * @return MitsoStudyModelBuilder instance of default study model builder
     */
    private function getDefaultStudyModelBuilder(): MitsoStudyModelBuilder
    {
        return new BaseMitsoStudyModelBuilder();
    }
}

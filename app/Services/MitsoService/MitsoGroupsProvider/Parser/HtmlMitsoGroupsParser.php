<?php


namespace App\Services\MitsoService\MitsoGroupsProvider\Parser;

use App\Services\MitsoService\MitsoGroupsProvider\MitsoGroup;
use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToParseGroupsFetchedDataException;
use App\Services\MitsoService\MitsoGroupsProvider\MitsoGroupBuilder;
use App\Services\MitsoService\MitsoGroupsProvider\BaseMitsoGroupBuilder;
use PHPHtmlParser\Dom;
use Exception;
use PHPHtmlParser\Dom\AbstractNode;

class HtmlMitsoGroupsParser implements MitsoGroupsParser
{
    private const GROUPS_SELECTOR = 'option';

    /**
     * @var MitsoGroupBuilder $groupBuilder
     */
    private $groupBuilder;

    /**
     * HtmlMitsoGroupsParser constructor.
     * @param MitsoGroupBuilder $builder
     */
    public function __construct(MitsoGroupBuilder $builder = null)
    {
        $this->groupBuilder = $builder ?? $this->getDefaultGroupBuilder();
    }


    /**
     * Parse html of groups.
     * @param string $html of groups
     * @return MitsoGroup[] groups available on current or next week
     * @throws FailedToParseGroupsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array
    {
        try {
            $dom = new Dom();
            $dom->loadStr($html);
            $faculties = $dom->find(self::GROUPS_SELECTOR);

            return array_map(function (AbstractNode $groupNode) {
                return $this->groupBuilder->withName($groupNode->getAttribute('value'))->withTitle($groupNode->text())->build();
            }, $faculties->toArray());
        } catch(Exception $e) {
            throw new FailedToParseGroupsFetchedDataException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create default group instance.
     * @return MitsoGroupBuilder instance of default group builder
     */
    private function getDefaultGroupBuilder(): MitsoGroupBuilder
    {
        return new BaseMitsoGroupBuilder();
    }
}

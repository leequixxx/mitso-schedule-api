<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider;

use App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher\MitsoStudyModelsFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\Parser\MitsoStudyModelsParser;
use App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher\GuzzleMitsoStudyModelsFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\Parser\HtmlMitsoStudyModelsParser;

class BaseMitsoStudyModelsProvider implements MitsoStudyModelsProvider
{
    /**
     * Create instance of study models fetcher.
     * @return MitsoStudyModelsFetcher instance
     */
    public function createFetcher(): MitsoStudyModelsFetcher
    {
        return new GuzzleMitsoStudyModelsFetcher();
    }

    /**
     * Create instance of study models parser.
     * @return MitsoStudyModelsParser instance
     */
    public function createParser(): MitsoStudyModelsParser
    {
        return new HtmlMitsoStudyModelsParser();
    }
}

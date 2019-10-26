<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider;

use App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher\MitsoStudyModelsFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\Parser\MitsoStudyModelsParser;

interface MitsoStudyModelsProvider
{
    /**
     * Create instance of study models fetcher.
     * @return MitsoStudyModelsFetcher instance
     */
    public function createFetcher(): MitsoStudyModelsFetcher;

    /**
     * Create instance of study models parser.
     * @return MitsoStudyModelsParser instance
     */
    public function createParser(): MitsoStudyModelsParser;
}

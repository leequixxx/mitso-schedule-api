<?php


namespace App\Services\MitsoService\MitsoGroupsProvider;

use App\Services\MitsoService\MitsoGroupsProvider\Parser\MitsoGroupsParser;
use App\Services\MitsoService\MitsoGroupsProvider\Fetcher\MitsoGroupsFetcher;
use App\Services\MitsoService\MitsoGroupsProvider\Fetcher\GuzzleMitsoGroupsFetcher;
use App\Services\MitsoService\MitsoGroupsProvider\Parser\HtmlMitsoGroupsParser;

class BaseMitsoGroupsProvider implements MitsoGroupsProvider
{
    /**
     * Create instance of groups fetcher.
     * @return MitsoGroupsFetcher instance
     */
    public function createFetcher(): MitsoGroupsFetcher
    {
        return new GuzzleMitsoGroupsFetcher();
    }

    /**
     * Create instance of groups parser.
     * @return MitsoGroupsParser instance
     */
    public function createParser(): MitsoGroupsParser
    {
        return new HtmlMitsoGroupsParser();
    }
}

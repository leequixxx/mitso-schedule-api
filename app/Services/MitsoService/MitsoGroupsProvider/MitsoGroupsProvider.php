<?php


namespace App\Services\MitsoService\MitsoGroupsProvider;

use App\Services\MitsoService\MitsoGroupsProvider\Fetcher\MitsoGroupsFetcher;
use App\Services\MitsoService\MitsoGroupsProvider\Parser\MitsoGroupsParser;

interface MitsoGroupsProvider
{
    /**
     * Create instance of groups fetcher.
     * @return MitsoGroupsFetcher instance
     */
    public function createFetcher(): MitsoGroupsFetcher;

    /**
     * Create instance of groups parser.
     * @return MitsoGroupsParser instance
     */
    public function createParser(): MitsoGroupsParser;
}

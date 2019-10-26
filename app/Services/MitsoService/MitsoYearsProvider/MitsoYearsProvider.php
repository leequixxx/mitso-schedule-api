<?php


namespace App\Services\MitsoService\MitsoYearsProvider;

use App\Services\MitsoService\MitsoYearsProvider\Fetcher\MitsoYearsFetcher;
use App\Services\MitsoService\MitsoYearsProvider\Parser\MitsoYearsParser;

interface MitsoYearsProvider
{
    /**
     * Create instance of years fetcher.
     * @return MitsoYearsFetcher instance
     */
    public function createFetcher(): MitsoYearsFetcher;

    /**
     * Create instance of years parser.
     * @return MitsoYearsParser instance
     */
    public function createParser(): MitsoYearsParser;
}

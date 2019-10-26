<?php


namespace App\Services\MitsoService\MitsoYearsProvider;

use App\Services\MitsoService\MitsoYearsProvider\Fetcher\MitsoYearsFetcher;
use App\Services\MitsoService\MitsoYearsProvider\Parser\MitsoYearsParser;
use App\Services\MitsoService\MitsoYearsProvider\Fetcher\GuzzleMitsoYearsFetcher;
use App\Services\MitsoService\MitsoYearsProvider\Parser\HtmlMitsoYearsParser;

class BaseMitsoYearsProvider implements MitsoYearsProvider
{
    public function createFetcher(): MitsoYearsFetcher
    {
        return new GuzzleMitsoYearsFetcher();
    }

    public function createParser(): MitsoYearsParser
    {
        return new HtmlMitsoYearsParser();
    }
}

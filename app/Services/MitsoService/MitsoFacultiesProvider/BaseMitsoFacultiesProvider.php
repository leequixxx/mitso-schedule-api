<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider;

use App\Services\MitsoService\MitsoFacultiesProvider\Parser\MitsoFacultiesParser;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\MitsoFacultiesFetcher;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\GuzzleMitsoFacultiesFetcher;
use App\Services\MitsoService\MitsoFacultiesProvider\Parser\HtmlMitsoFacultiesParser;

class BaseMitsoFacultiesProvider implements MitsoFacultiesProvider
{
    /**
     * Create instance of faculties fetcher.
     * @return MitsoFacultiesFetcher instance
     */
    public function createFetcher(): MitsoFacultiesFetcher
    {
        return new GuzzleMitsoFacultiesFetcher();
    }

    /**
     * Create instance of faculties parser.
     * @return MitsoFacultiesParser instance
     */
    public function createParser(): MitsoFacultiesParser
    {
        return new HtmlMitsoFacultiesParser();
    }
}

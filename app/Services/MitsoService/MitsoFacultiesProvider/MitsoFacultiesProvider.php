<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider;

use App\Services\MitsoService\MitsoFacultiesProvider\Parser\MitsoFacultiesParser;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\MitsoFacultiesFetcher;

interface MitsoFacultiesProvider
{
    /**
     * Create instance of faculties fetcher.
     * @return MitsoFacultiesFetcher instance
     */
    public function createFetcher(): MitsoFacultiesFetcher;

    /**
     * Create instance of faculties parser.
     * @return MitsoFacultiesParser instance
     */
    public function createParser(): MitsoFacultiesParser;
}

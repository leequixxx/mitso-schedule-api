<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider\Fetcher;

use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToFetchFacultiesException;

interface MitsoFacultiesFetcher
{
    /**
     * Fetch faculties available on current or next week in html format.
     * @return string html of faculties
     * @throws FailedToFetchFacultiesException when failed to fetch
     */
    public function fetch(): string;
}

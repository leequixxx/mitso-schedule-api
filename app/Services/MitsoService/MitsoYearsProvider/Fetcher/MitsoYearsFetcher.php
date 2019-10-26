<?php


namespace App\Services\MitsoService\MitsoYearsProvider\Fetcher;

use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToFetchYearsException;

interface MitsoYearsFetcher
{
    /**
     * Fetch years available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @param string $studyModelName name of study model
     * @return string html of years
     * @throws FailedToFetchYearsException when failed to fetch
     */
    public function fetch(string $facultyName, string $studyModelName): string;
}

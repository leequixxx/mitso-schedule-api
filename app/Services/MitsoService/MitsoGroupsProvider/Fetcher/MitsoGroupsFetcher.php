<?php


namespace App\Services\MitsoService\MitsoGroupsProvider\Fetcher;

use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToFetchGroupsExceptions;

interface MitsoGroupsFetcher
{
    /**
     * Fetch groups available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @param string $studyModelName name of study model
     * @param string $yearName name of year
     * @return string html of groups
     * @throws FailedToFetchGroupsExceptions when failed to fetch
     */
    public function fetch(string $facultyName, string $studyModelName, string $yearName): string;
}

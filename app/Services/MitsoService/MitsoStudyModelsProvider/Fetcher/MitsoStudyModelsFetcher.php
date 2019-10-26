<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher;

use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToFetchStudyModelsException;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;

interface MitsoStudyModelsFetcher
{
    /**
     * Fetch study models available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @return string html of study models
     * @throws FailedToFetchStudyModelsException when failed to fetch
     */
    public function fetch(string $facultyName): string;
}

<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider\Parser;

use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToParseFacultiesFetchedDataException;

interface MitsoFacultiesParser
{
    /**
     * Parse html of faculties.
     * @param string $html of faculties
     * @return MitsoFaculty[] faculties available on current or next week
     * @throws FailedToParseFacultiesFetchedDataException when failed to parse data
     */
    public function parse(string $html): array;
}

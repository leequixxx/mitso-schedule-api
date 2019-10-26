<?php


namespace App\Services\MitsoService\MitsoYearsProvider\Parser;

use App\Services\MitsoService\MitsoYearsProvider\MitsoYear;
use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToParseYearsFetchedDataException;

interface MitsoYearsParser
{
    /**
     * Parse html of years.
     * @param string $html of years
     * @return MitsoYear[] available on current or next week
     * @throws FailedToParseYearsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array;
}

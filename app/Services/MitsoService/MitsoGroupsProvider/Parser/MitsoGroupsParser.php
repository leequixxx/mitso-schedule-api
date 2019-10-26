<?php


namespace App\Services\MitsoService\MitsoGroupsProvider\Parser;

use App\Services\MitsoService\MitsoGroupsProvider\MitsoGroup;
use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToParseGroupsFetchedDataException;

interface MitsoGroupsParser
{
    /**
     * Parse html of groups.
     * @param string $html of groups
     * @return MitsoGroup[] groups available on current or next week
     * @throws FailedToParseGroupsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array;
}

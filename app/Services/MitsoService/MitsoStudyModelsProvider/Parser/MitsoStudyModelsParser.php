<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider\Parser;

use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToParseStudyModelsFetchedDataException;
use App\Services\MitsoService\MitsoStudyModelsProvider\MitsoStudyModel;

interface MitsoStudyModelsParser
{
    /**
     * Parse html of study models.
     * @param string $html of study models
     * @return MitsoStudyModel[] available on current or next week
     * @throws FailedToParseStudyModelsFetchedDataException when failed to parse data
     */
    public function parse(string $html): array;
}

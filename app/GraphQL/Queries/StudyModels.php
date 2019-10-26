<?php


namespace App\GraphQL\Queries;

use App\GraphQL\Resolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;
use App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher\MitsoStudyModelsFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\Parser\MitsoStudyModelsParser;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Services\MitsoService\MitsoStudyModelsProvider\MitsoStudyModel;
use App\StudyModel;
use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToFetchStudyModelsException;
use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToParseStudyModelsFetchedDataException;
use Exception;
use Illuminate\Support\Collection;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\MitsoFacultiesFetcher;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToFetchFacultiesException;
use App\Services\MitsoService\MitsoFacultiesProvider\Parser\MitsoFacultiesParser;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToParseFacultiesFetchedDataException;
use App\Faculty;

class StudyModels implements Resolver
{
    public const RESOURCE = 'studyModel';
    public const METHOD = 'getAll';

    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return Collection
     * @throws Exception
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $faculty = Faculty::find($args['faculty']);

        try {
            Log::debug('Trying to get study models fetch and parse service', $this->getLogOptions());
            $studyModelsFetcher = app()->make(MitsoStudyModelsFetcher::class);
            $studyModelsParser = app()->make(MitsoStudyModelsParser::class);

            Log::debug('Trying to fetch study models', $this->getLogOptions());
            $html = $this->fetchStudyModels($studyModelsFetcher, $args['faculty']);


            Log::debug('Trying to parse study models and save to DB', $this->getLogOptions());
            $studyModels = collect(array_map(function (MitsoStudyModel $studyModel) {
                return StudyModel::updateOrCreate(['name' => $studyModel->getName()], ['title' => $studyModel->getTitle()]);
            }, $this->parseStudyModels($studyModelsParser, $html)));
            $faculty->studyModels()->sync($studyModels->pluck('name'));

            Log::info('Study models fetched from MITSO site', $this->getLogOptions());
            return $studyModels;
        } catch (BindingResolutionException $e) {
            return $this->onError('Failed to get study models fetching service', $faculty);
        } catch (FailedToFetchStudyModelsException $e) {
            return $this->onError('Failed to fetch study models from MITSO site', $faculty);
        } catch (FailedToParseStudyModelsFetchedDataException $e) {
            return $this->onError('Failed to parse data from MITSO site', $faculty);
        } catch (Exception $e) {
            return $this->onError($e->getMessage(), $faculty);
        }
    }

    /**
     * Fetch html of study models from MITSO site.
     * @param MitsoStudyModelsFetcher $fetcher instance
     * @param string $faculty name of faculty
     * @return string html of study models
     * @throws FailedToFetchStudyModelsException when failed to fetch
     */
    private function fetchStudyModels(MitsoStudyModelsFetcher $fetcher, string $faculty): string {
        return $fetcher->fetch($faculty);
    }

    /**
     * Parse html of study models.
     * @param MitsoStudyModelsParser $parser instance
     * @param string $html of study models
     * @return MitsoStudyModel[] study models
     * @throws FailedToParseStudyModelsFetchedDataException
     */
    private function parseStudyModels(MitsoStudyModelsParser $parser, string $html): array {
        return $parser->parse($html);
    }

    /**
     * Log error and returns exception.
     * @param string $message
     * @param Faculty $faculty
     * @return Collection of study models
     * @throws Exception on study_models table is empty
     */
    private function onError(string $message, Faculty $faculty): Collection {
        if ($faculty->studyModels()->count() === 0) {
            Log::emergency($message . ' and study_models table is empty!', $this->getLogOptions());

            throw new Exception($message);
        } else {
            Log::critical($message . '!', $this->getLogOptions());

            return $faculty->studyModels;
        }
    }

    /**
     * Get default log options.
     * @return array default log options
     */
    private function getLogOptions(): array
    {
        return [
            'ip' => request()->ip(),
            'resource' => self::RESOURCE,
            'method' => self::METHOD,
        ];
    }
}

<?php


namespace App\GraphQL\Queries;

use App\GraphQL\Resolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;
use App\Services\MitsoService\MitsoYearsProvider\Fetcher\MitsoYearsFetcher;
use App\Services\MitsoService\MitsoYearsProvider\Parser\MitsoYearsParser;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\StudyModel;
use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToFetchYearsException;
use App\Services\MitsoService\MitsoYearsProvider\MitsoYear;
use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToParseYearsFetchedDataException;
use Illuminate\Support\Collection;
use Exception;
use App\Year;

class Years implements Resolver
{
    public const RESOURCE = 'year';
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
        $studyModel = StudyModel::find($args['studyModel']);

        try {
            Log::debug('Trying to get years fetch and parse service', $this->getLogOptions());
            $yearsFetcher = app()->make(MitsoYearsFetcher::class);
            $yearsParser = app()->make(MitsoYearsParser::class);

            Log::debug('Trying to fetch years', $this->getLogOptions());
            $html = $this->fetchYears($yearsFetcher, $args['faculty'], $args['studyModel']);


            Log::debug('Trying to parse years and save to DB', $this->getLogOptions());
            $years = collect(array_map(function (MitsoYear $year) {
                return Year::updateOrCreate(['name' => $year->getName()], ['number' => $year->getNumber()]);
            }, $this->parseYears($yearsParser, $html)));
            $studyModel->years()->sync($years->pluck('name'));

            Log::info('Years fetched from MITSO site', $this->getLogOptions());
            return $years;
        } catch (BindingResolutionException $e) {
            return $this->onError('Failed to get years fetching service', $studyModel);
        } catch (FailedToFetchYearsException $e) {
            return $this->onError('Failed to fetch years from MITSO site', $studyModel);
        } catch (FailedToParseYearsFetchedDataException $e) {
            return $this->onError('Failed to parse data from MITSO site', $studyModel);
        } catch (Exception $e) {
            return $this->onError($e->getMessage(), $studyModel);
        }
    }

    /**
     * Fetch html of years from MITSO site.
     * @param MitsoYearsFetcher $fetcher instance
     * @param string $faculty name of faculty
     * @param string $studyModel name of study model
     * @return string html of years
     * @throws FailedToFetchYearsException when failed to fetch
     */
    private function fetchYears(MitsoYearsFetcher $fetcher, string $faculty, string $studyModel): string {
        return $fetcher->fetch($faculty, $studyModel);
    }

    /**
     * Parse html of years.
     * @param MitsoYearsParser $parser instance
     * @param string $html of years
     * @return MitsoYear[] years
     * @throws FailedToParseYearsFetchedDataException
     */
    private function parseYears(MitsoYearsParser $parser, string $html): array {
        return $parser->parse($html);
    }

    /**
     * Log error and returns exception.
     * @param string $message
     * @param StudyModel $studyModel
     * @return Collection of years
     * @throws Exception on years table is empty
     */
    private function onError(string $message, StudyModel $studyModel): Collection {
        if ($studyModel->years()->count() === 0) {
            Log::emergency($message . ' and years table is empty!', $this->getLogOptions());

            throw new Exception($message);
        } else {
            Log::critical($message . '!', $this->getLogOptions());

            return $studyModel->years;
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

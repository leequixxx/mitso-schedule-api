<?php


namespace App\GraphQL\Queries;

use App\GraphQL\Resolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Collection;
use Exception;
use App\Group;
use App\Year;
use Log;
use App\Services\MitsoService\MitsoGroupsProvider\Fetcher\MitsoGroupsFetcher;
use App\Services\MitsoService\MitsoGroupsProvider\Parser\MitsoGroupsParser;
use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToFetchGroupsExceptions;
use App\Services\MitsoService\MitsoGroupsProvider\MitsoGroup;
use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToParseGroupsFetchedDataException;
use Illuminate\Contracts\Container\BindingResolutionException;

class Groups implements Resolver
{
    public const RESOURCE = 'group';
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
        $year = Year::find($args['year']);

        try {
            Log::debug('Trying to get groups fetch and parse service', $this->getLogOptions());
            $groupsFetcher = app()->make(MitsoGroupsFetcher::class);
            $groupsParser = app()->make(MitsoGroupsParser::class);

            Log::debug('Trying to fetch groups', $this->getLogOptions());
            $html = $this->fetchGroups($groupsFetcher, $args['faculty'], $args['studyModel'], $args['year']);


            Log::debug('Trying to parse groups and save to DB', $this->getLogOptions());
            $groups = collect(array_map(function (MitsoGroup $group) use ($year) {
                return Group::updateOrCreate(['name' => $group->getName()], ['title' => $group->getTitle(), 'year_name' => $year->name]);
            }, $this->parseGroups($groupsParser, $html)));

            Log::info('Groups fetched from MITSO site', $this->getLogOptions());
            return $groups;
        } catch (BindingResolutionException $e) {
            return $this->onError('Failed to get groups fetching service', $year);
        } catch (FailedToFetchGroupsExceptions $e) {
            return $this->onError('Failed to fetch groups from MITSO site', $year);
        } catch (FailedToParseGroupsFetchedDataException $e) {
            return $this->onError('Failed to parse data from MITSO site', $year);
        } catch (Exception $e) {
            return $this->onError($e->getMessage(), $year);
        }
    }

    /**
     * Fetch html of groups from MITSO site.
     * @param MitsoGroupsFetcher $fetcher instance
     * @param string $faculty name of faculty
     * @param string $studyModel name of study model
     * @param string $year name of year
     * @return string html of groups
     * @throws FailedToFetchGroupsExceptions when failed to fetch
     */
    private function fetchGroups(MitsoGroupsFetcher $fetcher, string $faculty, string $studyModel, string $year): string {
        return $fetcher->fetch($faculty, $studyModel, $year);
    }

    /**
     * Parse html of groups.
     * @param MitsoGroupsParser $parser instance
     * @param string $html of groups
     * @return MitsoGroup[] groups
     * @throws FailedToParseGroupsFetchedDataException
     */
    private function parseGroups(MitsoGroupsParser $parser, string $html): array {
        return $parser->parse($html);
    }

    /**
     * Log error and returns exception.
     * @param string $message
     * @param Year $year
     * @return Collection of groups
     * @throws Exception on groups table is empty
     */
    private function onError(string $message, Year $year): Collection {
        if ($year->groups()->count() === 0) {
            Log::emergency($message . ' and groups table is empty!', $this->getLogOptions());

            throw new Exception($message);
        } else {
            Log::critical($message . '!', $this->getLogOptions());

            return $year->groups;
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

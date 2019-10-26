<?php


namespace App\GraphQL\Queries;


use App\GraphQL\Resolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Contracts\Container\BindingResolutionException;
use GraphQL\Error\Error;
use App\Services\MitsoService\MitsoFacultiesProvider\Parser\MitsoFacultiesParser;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;
use Exception;
use App\Faculty;
use Log;
use Illuminate\Support\Collection;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToParseFacultiesFetchedDataException;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToFetchFacultiesException;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\MitsoFacultiesFetcher;

class Faculties implements Resolver
{
    public const RESOURCE = 'faculty';
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
        try {
            Log::debug('Trying to get faculties fetch and parse service', $this->getLogOptions());
            $facultiesFetcher = app()->make(MitsoFacultiesFetcher::class);
            $facultiesParser = app()->make(MitsoFacultiesParser::class);

            Log::debug('Trying to fetch faculties', $this->getLogOptions());
            $html = $this->fetchFaculties($facultiesFetcher);

            Log::debug('Trying to parse faculties and save to DB', $this->getLogOptions());
            $faculties = collect(array_map(function (MitsoFaculty $faculty) {
                 return Faculty::updateOrCreate(['name' => $faculty->getName()], ['title' => $faculty->getTitle()]);
            }, $this->parseFaculties($facultiesParser, $html)));

            Log::info('Faculties fetched from MITSO site', $this->getLogOptions());
            return $faculties;
        } catch (BindingResolutionException $e) {
            return $this->onError('Failed to get faculties fetching service');
        } catch (FailedToFetchFacultiesException $e) {
            return $this->onError('Failed to fetch faculties from MITSO site');
        } catch (FailedToParseFacultiesFetchedDataException $e) {
            return $this->onError('Failed to parse data from MITSO site');
        } catch (Exception $e) {
            return $this->onError($e->getMessage());
        }
    }

    /**
     * Fetch html of faculties from MITSO site.
     * @param MitsoFacultiesFetcher $fetcher instance
     * @return string html of faculties
     * @throws FailedToFetchFacultiesException when failed to fetch
     */
    private function fetchFaculties(MitsoFacultiesFetcher $fetcher): string {
        return $fetcher->fetch();
    }

    /**
     * Parse html of faculties.
     * @param MitsoFacultiesParser $parser instance
     * @param string $html of faculties
     * @return MitsoFaculty[] faculties
     * @throws FailedToParseFacultiesFetchedDataException
     */
    private function parseFaculties(MitsoFacultiesParser $parser, string $html): array {
        return $parser->parse($html);
    }

    /**
     * Log error and returns exception.
     * @param string $message
     * @return Collection of faculties
     * @throws Exception on faculties table is empty
     */
    private function onError(string $message): Collection {
        if (Faculty::count() === 0) {
            Log::emergency($message . ' and faculties table is empty!', $this->getLogOptions());

            throw new Exception($message);
        } else {
            Log::critical($message . '!', $this->getLogOptions());

            return Faculty::all();
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

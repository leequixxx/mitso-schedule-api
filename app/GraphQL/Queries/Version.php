<?php


namespace App\GraphQL\Queries;

use App\GraphQL\Resolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

class Version implements Resolver
{
    public const RESOURCE = 'version';
    public const METHOD = 'get';

    private const VERSION = '1.0.0';

    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Log::info('API version fetched', $this->getLogOptions());

        return self::VERSION;
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

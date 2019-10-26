<?php


namespace App\GraphQL;


use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

interface Resolver
{
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo);
}

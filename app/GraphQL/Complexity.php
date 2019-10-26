<?php


namespace App\GraphQL;


interface Complexity
{
    public function complexity(int $childrenComplexity, array $args): int;
}

<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Facades;

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\NodeDumper;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use PhpParser\Parser\Php7;

class PhpParser
{
    public static function parseNamespace(string $context): string
    {
        $parser = self::getParser();
        $nodeFinder = self::getNodeFinder();

        return implode('\\', $nodeFinder->findFirstInstanceOf(
            $parser->parse($context),
            Node\Stmt\Namespace_::class)
            ->name
            ->parts
        );
    }

    public static function parseName(string $context): string
    {
        $parser = self::getParser();
        $nodeFinder = self::getNodeFinder();

        return $nodeFinder->findFirst(
            $parser->parse($context),
            function (Node $node) {
                return $node instanceof Node\Stmt\Class_ 
                    || $node instanceof Node\Stmt\Interface_;
            })
            ->name
            ->name;
    }

    private static function getParser(): Php7
    {
        return (new ParserFactory)->create(ParserFactory::ONLY_PHP7);
    }

    private static function getNodeFinder(): NodeFinder
    {
        return new NodeFinder();
    }
}

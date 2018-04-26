<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Facades;

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\Parser\Php7;
use PhpParser\Node;

class PhpParser
{
    public static function parseNamespace(string $context): string
    {
        return self::find($context, function (Node $node) {
            if ($node instanceof Node\Stmt\Namespace_) {
                return implode('\\', $node->name->parts);
            }
        });
    }

    public static function parseName(string $context): string
    {
        return self::find($context, function (Node $node) {
            if ($node instanceof Node\Stmt\Class_ 
                || $node instanceof Node\Stmt\Interface_) {
                return $node->name;
            }
        });
    }

    private static function getParser(): Php7
    {
        return (new ParserFactory)->create(ParserFactory::ONLY_PHP7);
    }

    private static function find(string $context, callable $callback)
    {
        $parser = self::getParser();

        $ast = $parser->parse($context);

        return self::iterate($ast, $callback);
    }

    private static function iterate(iterable $data, callable $callback)
    {
        $result = null;

        foreach ($data as $node) {
            $result = $callback($node);

            if ($result === null 
                && property_exists($node, 'stmts') 
                && $node->stmts !== null) {
                $result = self::iterate($node->stmts, $callback);
            }

            if ($result !== null) {
                return $result;
            }
        }
    }
}

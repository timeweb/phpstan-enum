<?php

declare(strict_types=1);

namespace Timeweb\PHPStan\Type;

use MyCLabs\Enum\Enum;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\ExpressionTypeResolverExtension;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * Narrows `$enum->value` and `$enum->getValue()` to the union of the enum constant values,
 * so `match`/`switch` over them can be seen as exhaustive.
 */
class EnumValueTypeResolverExtension implements ExpressionTypeResolverExtension
{
    public function getType(Expr $expr, Scope $scope): ?Type
    {
        if (!$expr instanceof PropertyFetch && !$expr instanceof MethodCall) {
            return null;
        }

        if (!$expr->name instanceof Identifier) {
            return null;
        }

        $isValueFetch = $expr instanceof PropertyFetch && $expr->name->toString() === 'value';
        $isGetValueCall = $expr instanceof MethodCall
            && $expr->name->toLowerString() === 'getvalue'
            && $expr->getArgs() === [];

        if (!$isValueFetch && !$isGetValueCall) {
            return null;
        }

        // A stored type comes from narrowing (if/match/assignment) and is more precise than ours.
        if ($scope->hasExpressionType($expr)->yes()) {
            return null;
        }

        $classReflections = $scope->getType($expr->var)->getObjectClassReflections();
        if ($classReflections === []) {
            return null;
        }

        $types = [];
        foreach ($classReflections as $classReflection) {
            // shortcut: constants added by a subclass of a non-final enum are not included,
            // handle them if someone extends concrete enums.
            if (!$classReflection->isSubclassOf(Enum::class)) {
                return null;
            }

            $constants = $classReflection->getNativeReflection()->getConstants();
            if ($constants === []) {
                return null;
            }

            foreach ($constants as $value) {
                $types[] = ConstantTypeHelper::getTypeFromValue($value);
            }
        }

        return TypeCombinator::union(...$types);
    }
}

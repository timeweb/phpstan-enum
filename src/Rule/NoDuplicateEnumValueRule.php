<?php

declare(strict_types=1);

namespace Timeweb\PHPStan\Rule;

use MyCLabs\Enum\Enum;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassConstantsNode;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

/**
 * @phpstan-implements Rule<ClassConstantsNode>
 */
class NoDuplicateEnumValueRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassConstantsNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->getClass() instanceof Class_) {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if (!$scope->isInClass() || !$classReflection) {
            throw new ShouldNotHappenException();
        }

        if (!$classReflection->isSubclassOf(Enum::class)) {
            return [];
        }

        $duplicatedKeysValue = $this->findDuplicatedKeys($node);
        if (empty($duplicatedKeysValue)) {
            return [];
        }

        return [
            sprintf(
                'Enum %s contains duplicated values for %s properties',
                $classReflection->getName(),
                implode(', ', $duplicatedKeysValue)
            ),
        ];
    }

    /**
     * @return string[]
     */
    private function findDuplicatedKeys(ClassConstantsNode $node): array
    {
        $constants = $this->getNodeConstants($node);

        $duplicatedValues = array_filter(
            array_count_values($constants),
            static function ($value) {
                return $value > 1;
            }
        );

        $duplicatedKeys = [];
        foreach ($duplicatedValues as $value => $count) {
            $duplicatedKeys = array_merge($duplicatedKeys, array_keys($constants, $value));
        }

        return array_unique($duplicatedKeys);
    }

    /**
     * @return array<string, mixed>
     */
    private function getNodeConstants(ClassConstantsNode $node): array
    {
        $constants = [];
        foreach ($node->getConstants() as $constant) {
            foreach ($constant->consts as $const) {
                $constantName = $const->name->toString();
                $constants[$constantName] = $const->value->value ?? null;
            }
        }

        return $constants;
    }
}

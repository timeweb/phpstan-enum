<?php

declare(strict_types=1);

namespace Timeweb\PHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class EnumMethodReflection implements MethodReflection
{
    /**
     * @var ClassReflection
     */
    private $classReflection;

    /**
     * @var string
     */
    private $name;

    public function __construct(ClassReflection $classReflection, string $name)
    {
        $this->classReflection = $classReflection;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function isVariadic(): bool
    {
        return false;
    }

    public function getReturnType(): Type
    {
        return new ObjectType($this->classReflection->getName(), false);
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function isStatic(): bool
    {
        return true;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getPrototype(): MethodReflection
    {
        return $this;
    }
}

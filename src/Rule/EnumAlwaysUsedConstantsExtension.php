<?php

declare(strict_types=1);

namespace Timeweb\PHPStan\Rule;

use MyCLabs\Enum\Enum;
use PHPStan\Reflection\ClassConstantReflection;
use PHPStan\Rules\Constants\AlwaysUsedClassConstantsExtension;

class EnumAlwaysUsedConstantsExtension implements AlwaysUsedClassConstantsExtension
{
    public function isAlwaysUsed(ClassConstantReflection $constant): bool
    {
        return $constant->getDeclaringClass()->isSubclassOf(Enum::class);
    }
}

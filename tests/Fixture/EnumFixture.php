<?php

declare(strict_types=1);

namespace Timeweb\Tests\PHPStan\Fixture;

use MyCLabs\Enum\Enum;

class EnumFixture extends Enum
{
    const MEMBER = 'member';

    public const PUBLIC_CONST = 'public';
    private const PRIVATE_CONST = 'private';
}

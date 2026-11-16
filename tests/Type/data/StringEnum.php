<?php

namespace EnumValueType;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 */
class StringEnum extends Enum
{
    public const FOO = 'foo';
    public const BAR = 'bar';
}

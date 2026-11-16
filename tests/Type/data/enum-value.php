<?php

namespace EnumValueType;

use MyCLabs\Enum\Enum;

use function PHPStan\Testing\assertType;

/**
 * @extends Enum<int>
 */
class IntEnum extends Enum
{
    public const FOO = 1;
    public const BAR = 2;
    private const BAZ = 3;

    public function test(): void
    {
        assertType('1|2|3', $this->value);
        assertType('1|2|3', $this->getValue());
    }
}

function test(IntEnum $int, StringEnum $string, NotAnEnum $notEnum): void
{
    assertType('1|2|3', $int->getValue());
    assertType("'bar'|'foo'", $string->getValue());
    assertType('int', $notEnum->value);
    assertType('int', $notEnum->getValue());

    if ($int->getValue() === IntEnum::FOO) {
        return;
    }

    assertType('2|3', $int->getValue());
}

/**
 * @param IntEnum|StringEnum $enum
 */
function testUnion($enum): void
{
    assertType("1|2|3|'bar'|'foo'", $enum->getValue());
}

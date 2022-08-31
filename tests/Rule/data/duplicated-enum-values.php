<?php

namespace DuplicateEumValues;

use MyCLabs\Enum\Enum;

class MyEnum extends Enum
{
    public const PROP_1 = 1;
    protected const PROP_2 = 2;
    private const DUPLICATED = 1;
}

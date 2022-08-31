<?php

declare(strict_types=1);

namespace Timeweb\Tests\PHPStan\Rule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Timeweb\PHPStan\Rule\NoDuplicateEnumValueRule;

/**
 * @coversDefaultClass \Timeweb\PHPStan\Rule\NoDuplicateEnumValueRule
 */
class NoDuplicateEnumValueRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoDuplicateEnumValueRule();
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/duplicated-enum-values.php'], [
            [
                'Enum DuplicateEumValues\MyEnum contains duplicated values for PROP_1, DUPLICATED properties',
                7,
            ],
        ]);
    }
}

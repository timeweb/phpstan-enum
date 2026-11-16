<?php

declare(strict_types=1);

namespace Timeweb\Tests\PHPStan\Type;

use PHPStan\Testing\TypeInferenceTestCase;

/**
 * @coversDefaultClass \Timeweb\PHPStan\Type\EnumValueTypeResolverExtension
 */
class EnumValueTypeResolverExtensionTest extends TypeInferenceTestCase
{
    /**
     * @return iterable<mixed>
     */
    public function dataFileAsserts(): iterable
    {
        yield from self::gatherAssertTypes(__DIR__ . '/data/enum-value.php');
    }

    /**
     * @dataProvider dataFileAsserts
     * @param mixed ...$args
     */
    public function testFileAsserts(string $assertType, string $file, ...$args): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../extension.neon'];
    }
}

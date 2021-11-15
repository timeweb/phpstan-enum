<?php

declare(strict_types=1);

namespace Timeweb\Tests\PHPStan\Rule;

use PHPStan\Testing\PHPStanTestCase;
use Timeweb\PHPStan\Rule\EnumAlwaysUsedConstantsExtension;
use Timeweb\Tests\PHPStan\Fixture\EnumFixture;

/**
 * @coversDefaultClass \Timeweb\PHPStan\Rule\EnumAlwaysUsedConstantsExtension
 */
class EnumAlwaysUsedConstantsExtensionTest extends PHPStanTestCase
{
    /**
     * @var \PHPStan\Broker\Broker
     */
    protected $broker;

    /**
     * @var EnumAlwaysUsedConstantsExtension
     */
    protected $constantsExtension;

    public function setUp(): void
    {
        $this->broker = $this->createBroker();
        $this->constantsExtension = new EnumAlwaysUsedConstantsExtension();
    }

    /**
     * @covers ::isAlwaysUsed
     * @dataProvider enumFixtureProperties
     */
    public function testEnumConstantsAreConsideredAsAlwaysUsed(string $constantName): void
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $constantReflection = $classReflection->getConstant($constantName);

        $this->assertTrue($this->constantsExtension->isAlwaysUsed($constantReflection));
    }

    /**
     * @return string[][]
     */
    public function enumFixtureProperties(): array
    {
        return [
            ['MEMBER'],
            ['PUBLIC_CONST'],
            ['PRIVATE_CONST'],
        ];
    }
}

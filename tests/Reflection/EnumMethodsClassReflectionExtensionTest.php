<?php

declare(strict_types=1);

use PHPStan\Testing\TestCase;
use Timeweb\PHPStan\Reflection\EnumMethodReflection;
use Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension;

/**
 * @coversDefaultClass Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension
 */
class EnumMethodsClassReflectionExtensionTest extends TestCase
{
    /**
     * @var \PHPStan\Broker\Broker
     */
    protected $broker;

    /**
     * @var EnumMethodsClassReflectionExtension
     */
    protected $reflectionExtension;

    public function setUp()
    {
        $this->broker = $this->createBroker();
        $this->reflectionExtension = new EnumMethodsClassReflectionExtension();
    }

    /**
     * @covers ::hasMethod
     * @dataProvider methodNameDataProvider
     */
    public function testEnumMethodsCanBeFoundInEnumSubclasses(bool $expected, string $methodName)
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $hasMethod = $this->reflectionExtension->hasMethod($classReflection, $methodName);

        $this->assertEquals($expected, $hasMethod);
    }

    public function methodNameDataProvider(): array
    {
        return [
            [true, 'MEMBER'],
            [false, 'NOT_A_MEMBER'],
        ];
    }

    /**
     * @covers ::hasMethod
     */
    public function testEnumMethodsCannotBeFoundInNonEnumSubclasses()
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $hasMethod = $this->reflectionExtension->hasMethod($classReflection, 'SOME_NAME');

        $this->assertFalse($hasMethod);
    }

    /**
     * @covers ::getMethod
     * @uses Timeweb\PHPStan\Reflection\EnumMethodReflection
     */
    public function testEnumMethodReflectionCanBeObtained()
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $methodReflection = $this->reflectionExtension->getMethod($classReflection, 'SOME_NAME');

        $this->assertInstanceOf(EnumMethodReflection::class, $methodReflection);
    }
}

<?php

declare(strict_types=1);

namespace Timeweb\Tests\PHPStan\Reflection;

use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Testing\PHPStanTestCase;
use PHPStan\Type\VerbosityLevel;
use Timeweb\PHPStan\Reflection\EnumMethodReflection;
use Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension;
use Timeweb\Tests\PHPStan\Fixture\EnumFixture;

/**
 * @coversDefaultClass \Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension
 */
class EnumMethodsClassReflectionExtensionTest extends PHPStanTestCase
{
    /**
     * @var \PHPStan\Broker\Broker
     */
    protected $broker;

    /**
     * @var EnumMethodsClassReflectionExtension
     */
    protected $reflectionExtension;

    public function setUp(): void
    {
        $this->broker = $this->createBroker();
        $this->reflectionExtension = new EnumMethodsClassReflectionExtension();
    }

    /**
     * @covers ::hasMethod
     * @dataProvider methodNameDataProvider
     */
    public function testEnumMethodsCanBeFoundInEnumSubclasses(bool $expected, string $methodName): void
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $hasMethod = $this->reflectionExtension->hasMethod($classReflection, $methodName);

        $this->assertEquals($expected, $hasMethod);
    }

    /**
     * @return array[]
     */
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
    public function testEnumMethodsCannotBeFoundInNonEnumSubclasses(): void
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $hasMethod = $this->reflectionExtension->hasMethod($classReflection, 'SOME_NAME');

        $this->assertFalse($hasMethod);
    }

    /**
     * @covers ::getMethod
     * @uses \Timeweb\PHPStan\Reflection\EnumMethodReflection
     */
    public function testEnumMethodReflectionCanBeObtained(): void
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $methodReflection = $this->reflectionExtension->getMethod($classReflection, 'SOME_NAME');

        $this->assertInstanceOf(EnumMethodReflection::class, $methodReflection);
    }

    /**
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getName
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getDeclaringClass
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isStatic
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isPrivate
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isPublic
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getPrototype
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getVariants
     * @uses \Timeweb\PHPStan\Reflection\EnumMethodReflection
     * @dataProvider enumFixtureProperties
     */
    public function testEnumMethodProperties(string $propertyName): void
    {
        $classReflection = $this->broker->getClass(EnumFixture::class);
        $methodReflection = $this->reflectionExtension->getMethod($classReflection, $propertyName);
        $parametersAcceptor = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());

        $this->assertSame($propertyName, $methodReflection->getName());
        $this->assertSame($classReflection, $methodReflection->getDeclaringClass());
        $this->assertTrue($methodReflection->isStatic());
        $this->assertFalse($methodReflection->isPrivate());
        $this->assertTrue($methodReflection->isPublic());
        $this->assertSame(EnumFixture::class, $parametersAcceptor->getReturnType()->describe(VerbosityLevel::value()));
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

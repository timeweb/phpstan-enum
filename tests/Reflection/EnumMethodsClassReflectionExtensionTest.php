<?php

declare(strict_types=1);

use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Testing\TestCase;
use PHPStan\Type\VerbosityLevel;
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

    /**
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getName
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getDeclaringClass
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isStatic
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isPrivate
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::isPublic
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getPrototype
     * @covers \Timeweb\PHPStan\Reflection\EnumMethodReflection::getVariants
     * @uses Timeweb\PHPStan\Reflection\EnumMethodReflection
     * @dataProvider enumFixtureProperties
     */
    public function testEnumMethodProperties(string $propertyName)
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

    public function enumFixtureProperties(): array
    {
        return [
            ['MEMBER'],
            ['PUBLIC_CONST'],
            ['PRIVATE_CONST'],
        ];
    }
}

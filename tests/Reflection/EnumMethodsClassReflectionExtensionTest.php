<?php

declare(strict_types=1);

use MyCLabs\Enum\Enum;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Timeweb\PHPStan\Reflection\EnumMethodReflection;
use Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension;

/**
 * @coversDefaultClass Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension
 */
class EnumMethodsClassReflectionExtensionTest extends TestCase
{
    /**
     * @var EnumMethodsClassReflectionExtension
     */
    protected $reflectionExtension;

    public function setUp()
    {
        $this->reflectionExtension = new EnumMethodsClassReflectionExtension();
    }

    /**
     * @covers ::hasMethod
     * @dataProvider methodNameDataProvider
     */
    public function testEnumMethodsCanBeFoundInEnumSubclasses(bool $expected, string $methodName)
    {
        $classReflection = $this->createMock(ClassReflection::class);

        $classReflection->expects($this->once())
            ->method('getNativeReflection')
            ->will($this->returnValue(new ReflectionClass(EnumFixture::class)))
        ;

        $classReflection->expects($this->once())
            ->method('isSubclassOf')
            ->with($this->equalTo(Enum::class))
            ->will($this->returnValue(true))
        ;

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
        $classReflection = $this->createMock(ClassReflection::class);

        $classReflection->expects($this->once())
            ->method('isSubclassOf')
            ->with($this->equalTo(Enum::class))
            ->will($this->returnValue(false))
        ;

        $hasMethod = $this->reflectionExtension->hasMethod($classReflection, 'SOME_NAME');

        $this->assertFalse($hasMethod);
    }

    /**
     * @covers ::getMethod
     * @uses Timeweb\PHPStan\Reflection\EnumMethodReflection
     */
    public function testEnumMethodReflectionCanBeObtained()
    {
        $classReflection = $this->createMock(ClassReflection::class);

        $methodReflection = $this->reflectionExtension->getMethod($classReflection, 'SOME_NAME');

        $this->assertInstanceOf(EnumMethodReflection::class, $methodReflection);
    }
}

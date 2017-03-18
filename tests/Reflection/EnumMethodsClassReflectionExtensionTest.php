<?php

declare(strict_types=1);

use Timeweb\PHPStan\Reflection\EnumMethodReflection;
use Timeweb\PHPStan\Reflection\EnumMethodsClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;

class EnumMethodsClassReflectionExtensionTest extends TestCase
{
    protected $reflectionExtension;

    public function setUp()
    {
        $this->reflectionExtension = new EnumMethodsClassReflectionExtension();
    }

    /**
     * @dataProvider methodNameDataProvider
     */
    public function testMethodPresenceCanBeDetermined(bool $expected, string $methodName)
    {
        $classReflection = $this->createMock(ClassReflection::class);

        $classReflection->expects($this->once())
            ->method('getNativeReflection')
            ->will($this->returnValue(new ReflectionClass(EnumFixture::class)))
        ;

        $classReflection->expects($this->once())
            ->method('isSubclassOf')
            ->with($this->equalTo(MyCLabs\Enum\Enum::class))
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

    public function testMethodReflectionCanBeObtained()
    {
        $classReflection = $this->createMock(ClassReflection::class);

        $methodReflection = $this->reflectionExtension->getMethod($classReflection, 'NAME');

        $this->assertInstanceOf(EnumMethodReflection::class, $methodReflection);
    }
}

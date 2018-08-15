<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Math;

use Sfynx\SpecificationBundle\Specification\Math\AddSpec;
use Sfynx\SpecificationBundle\Specification\Math\CeilSpec;
use Sfynx\SpecificationBundle\Specification\Math\DivideSpec;
use Sfynx\SpecificationBundle\Specification\Math\ExponentiateSpec;
use Sfynx\SpecificationBundle\Specification\Math\FloorSpec;
use Sfynx\SpecificationBundle\Specification\Math\ModuloSpec;
use Sfynx\SpecificationBundle\Specification\Math\MultiplySpec;
use Sfynx\SpecificationBundle\Specification\Math\NegateSpec;
use Sfynx\SpecificationBundle\Specification\Math\SubstractSpec;

class MathTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
        AddSpec::resetProfiler();
    }

    public function testAddition()
    {
        $expected = 10;
        $actual = (new AddSpec(5, 5))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 10.2;
        $actual = (new AddSpec(5.10, 5.100))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = -5;
        $actual = (new AddSpec(5, -10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testCeil()
    {
        $expected = 10;
        $actual = (new CeilSpec(9.5))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 10;
        $actual = (new CeilSpec(10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 10;
        $actual = (new CeilSpec(10.0))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testDivide()
    {
        $expected = 5;
        $actual = (new DivideSpec(10, 2))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Exception
     */
    public function testDivideByZero()
    {
        $actual = (new DivideSpec(10, 0))->isSatisfiedBy();
    }

    public function testExponentiate()
    {
        $expected = 4;
        $actual = (new ExponentiateSpec(2, 2))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testFloor()
    {
        $expected = 9;
        $actual = (new FloorSpec(9.5))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 10;
        $actual = (new FloorSpec(10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 10;
        $actual = (new FloorSpec(10.0))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

    }

    public function testModulo()
    {
        $expected = 1;
        $actual = (new ModuloSpec(10, 3))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testMultiply()
    {
        $expected = 9;
        $actual = (new MultiplySpec(3, 3))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testNegation()
    {
        $expected = -9;
        $actual = (new NegateSpec(9))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 9;
        $actual = (new NegateSpec(-9))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    public function testSubstract()
    {
        $expected = 8;
        $actual = (new SubstractSpec(10, 2))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = -8;
        $actual = (new SubstractSpec(2, 10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = -12;
        $actual = (new SubstractSpec(-2, 10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);

        $expected = 8;
        $actual = (new SubstractSpec(-2, -10))->isSatisfiedBy();
        $this->assertEquals($expected, $actual);
    }

    // (10 + (-5)) + (50 + 100)
    public function testOperation1()
    {
        $sum = new AddSpec(
            new AddSpec(10, -5),
            new AddSpec(50, 100)
        );
        $expected = 10-5+50+100;
        $this->assertEquals($expected, $sum->isSatisfiedBy());
    }
}

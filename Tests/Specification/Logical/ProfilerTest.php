<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;


use Sfynx\SpecificationBundle\Specification\Logical\AndSpec;
use Sfynx\SpecificationBundle\Specification\Logical\NotSpec;
use Sfynx\SpecificationBundle\Specification\Logical\TrueSpec;
use Sfynx\SpecificationBundle\Specification\Logical\OrSpec;
use Sfynx\SpecificationBundle\Specification\Logical\XorSpec;
use DateTime;
use stdClass;

class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    private $birthdaySpec;
    private $dayOffSpec;
    private $holidaySpec;
    private $object;
    private $combinedSpec;
    private $combinedSpec2;

    public function setUp()
    {
        //init my birthday
        $dayOfBirth = new \DateTime('1995-05-05');
        $this->birthdaySpec = new MyBirthdaySpec($dayOfBirth);

        $dayOffArray = [];

        //init days off for every 15th of all months
        for ($month= 1; $month <= 12; $month++) {
            // %02d :: always two digits and add 0 if just one digit
            $dayOffArray[] = new DateTime('2016-'.sprintf("%02d", $month).'-15');
        }

        $this->dayOffSpec = new MyDayOffSpec($dayOffArray);



        //holidays 2 weeks in august
        $this->holidaySpec = new MyHolidaySpec(self::initMyHolidaySpec());

        $this->object = new stdClass();

        // NOT ( birthday || dayOff || holiday )

        $this->combinedSpec =
            new NotSpec(
            new OrSpec(
                new OrSpec($this->birthdaySpec, $this->dayOffSpec),
                $this->holidaySpec
            )
        );

        // => ( !birthday && !dayOff && !holiday )

        $this->combinedSpec2 = new AndSpec(
            new NotSpec($this->birthdaySpec),
            new AndSpec(
                new NotSpec($this->dayOffSpec),
                new NotSpec($this->holidaySpec)
            )
        );
    }

    public function tearDown()
    {
        OrSpec::resetProfiler();
    }

    public function initMyHolidaySpec()
    {
        return  [
            new DateTime('2016-08-01'),
            new DateTime('2016-08-02'),
            new DateTime('2016-08-03'),
            new DateTime('2016-08-04'),
            new DateTime('2016-08-05'),
            new DateTime('2016-08-08'),
            new DateTime('2016-08-09'),
            new DateTime('2016-08-10'),
            new DateTime('2016-08-11'),
            new DateTime('2016-08-12'),
        ];

    }

    public function testDisplayName()
    {
        $this->assertEquals('MyBirthdaySpec', $this->birthdaySpec->getLogicalExpression());
    }

    public function testDisplayName2()
    {
        $this->assertEquals('NOT(MyBirthdaySpec)', (new NotSpec($this->birthdaySpec))->getLogicalExpression());
    }

    public function testDisplayName3()
    {
        $this->assertEquals('(MyBirthdaySpec AND TrueSpec)', (new AndSpec($this->birthdaySpec, new TrueSpec()))->getLogicalExpression());
    }

    public function testDisplayName4()
    {
        $this->assertEquals('(MyBirthdaySpec OR TrueSpec)', (new OrSpec($this->birthdaySpec, new TrueSpec()))->getLogicalExpression());
    }

    public function testDisplayName5()
    {
        $this->assertEquals('(MyBirthdaySpec XOR TrueSpec)', (new XorSpec($this->birthdaySpec, new TrueSpec()))->getLogicalExpression());
    }

    public function testDisplayName6()
    {
        $this->assertEquals('((MyBirthdaySpec XOR TrueSpec) AND MyBirthdaySpec)', (new AndSpec(new XorSpec($this->birthdaySpec, new TrueSpec()), $this->birthdaySpec))->getLogicalExpression());
    }

    public function testDisplayName7()
    {
        $this->assertEquals('NOT(((MyBirthdaySpec OR MyDayOffSpec) OR MyHolidaySpec))', $this->combinedSpec->getLogicalExpression());
    }

    public function testDisplayName8()
    {
        $this->assertEquals('(NOT(MyBirthdaySpec) AND (NOT(MyDayOffSpec) AND NOT(MyHolidaySpec)))', $this->combinedSpec2->getLogicalExpression());
    }

    public function testDisplayResult()
    {
        $this->object->date = new DateTime('2015-05-06');
        $expected = [
            ['MyBirthdaySpec' => false],
            ['NOT(MyBirthdaySpec)' => true],
            ['MyDayOffSpec' => false],
            ['NOT(MyDayOffSpec)' => true],
            ['MyHolidaySpec' => false],
            ['NOT(MyHolidaySpec)' => true],
            ['(NOT(MyDayOffSpec) AND NOT(MyHolidaySpec))' => true],
            ['(NOT(MyBirthdaySpec) AND (NOT(MyDayOffSpec) AND NOT(MyHolidaySpec)))' => true],
        ];



        $this->combinedSpec2->isSatisfiedBy($this->object);
        $actual = $this->combinedSpec2->getProfiler();

        $this->assertEquals($expected, $actual);
    }

    public function testDisplayResult2()
    {
        $this->object->date = new DateTime('2015-05-06');

        $expected = [
            ['MyBirthdaySpec' => false],
            ['NOT(MyBirthdaySpec)' => true],
            ['MyDayOffSpec' => false],
            ['NOT(MyDayOffSpec)' => true],
            ['MyHolidaySpec' => false],
            ['NOT(MyHolidaySpec)' => true],
            ['(NOT(MyDayOffSpec) AND NOT(MyHolidaySpec))' => true],
            ['(NOT(MyBirthdaySpec) AND (NOT(MyDayOffSpec) AND NOT(MyHolidaySpec)))' => true]
        ];

        $this->combinedSpec2->isSatisfiedBy($this->object);
        $actual = $this->combinedSpec->getProfiler();

        $this->assertEquals($expected, $actual);
    }
}

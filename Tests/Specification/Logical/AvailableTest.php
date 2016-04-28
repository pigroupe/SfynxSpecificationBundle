<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\Logical\AndSpec;
use Sfynx\SpecificationBundle\Specification\Logical\OrSpec;
use Sfynx\SpecificationBundle\Specification\Logical\NotSpec;
use stdClass;
use DateTime;

class AvailableTest extends \PHPUnit_Framework_TestCase
{
    private $birthdaySpec;
    private $dayOffSpec;
    private $holidaySpec;
    private $object;
    private $combinedSpec;

    public function setUp()
    {
        $dayOffArray = [];

        //init days off for every 15th of all months
        for ($month= 1; $month <= 12; $month++) {
            // %02d :: always two digits and add 0 if just one digit
            $dayOffArray[] = new DateTime('2016-'.sprintf("%02d", $month).'-15');
        }

        $this->dayOffSpec = new MyDayOffSpec($dayOffArray);

        //init my birthday
        $dayOfBirth = new \DateTime('1995-05-05');
        $this->birthdaySpec = new MyBirthdaySpec($dayOfBirth);

        //holidays 2 weeks in august
        $holidays = [
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

        $this->holidaySpec = new MyHolidaySpec($holidays);

        $this->object = new stdClass();

        // NOT ( birthday || dayOff || holiday )

        $this->combinedSpec2 =
            new NotSpec(
            new OrSpec(
                new OrSpec($this->birthdaySpec, $this->dayOffSpec),
                $this->holidaySpec
            )
        );

        // => ( !birthday && !dayOff && !holiday )

        $this->combinedSpec = new AndSpec(
            new NotSpec($this->birthdaySpec),
            new AndSpec(
                new NotSpec($this->dayOffSpec),
                new NotSpec($this->holidaySpec)
            )
        );
    }

    public function tearDown()
    {
    }

    // Bool : True or False each time
    public function testIsNotMyBirthday()
    {
        $this->object->date = new DateTime('1985-05-05');
        $this->assertTrue($this->combinedSpec->isSatisfiedBy($this->object));

    }

    public function testMyBirthday()
    {
        $this->object->date = new DateTime('1995-05-05');
        $this->assertTrue($this->birthdaySpec->isSatisfiedBy($this->object));

        $this->object->date = new DateTime('1985-05-05');
        $this->assertFalse($this->birthdaySpec->isSatisfiedBy($this->object));
    }

    public function testIsInMyDayOff()
    {
        $this->object->date = new DateTime('2016-05-15');
        $this->assertTrue($this->dayOffSpec->isSatisfiedBy($this->object));

        $this->object->date = new DateTime('2016-05-14');
        $this->assertFalse($this->dayOffSpec->isSatisfiedBy($this->object));
    }

    public function testIsInMyHoliday()
    {
        $this->object->date = new DateTime('2016-08-02');
        $this->assertTrue($this->holidaySpec->isSatisfiedBy($this->object));

        $this->object->date = new DateTime('2016-05-14');
        $this->assertFalse($this->holidaySpec->isSatisfiedBy($this->object));
    }

    // Combine Test with all specs (birthday, dayOff, holiday)

    public function testIsAvailable()
    {
        $this->object->date = new DateTime('2016-09-02');
        $this->assertTrue($this->combinedSpec->isSatisfiedBy($this->object));
    }

    public function testIsNotAvailableBecauseBirthday()
    {
        $this->object->date = new DateTime('1995-05-05');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's birthday
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (day off, holiday)
    }

    public function testIsNotAvailableBecauseDayOff()
    {
        $this->object->date = new DateTime('2016-05-15');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's day off
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (holiday, birthday)
    }

    public function testIsNotAvailableBecauseHoliday()
    {
        $this->object->date = new DateTime('2016-08-02');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's holiday
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (day off, birthday)
    }
}

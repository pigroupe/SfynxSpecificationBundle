<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

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
        $this->birthdaySpec = new MyBirthdaySpec('the date is not my birthday', '1995-05-05');
        $this->dayOffSpec = new MyDayOffSpec('the date is not in my days off');
        $this->holidaySpec = new MyHolidaySpec('the date is not in my holiday');
        $this->object = new stdClass();
        $this->combinedSpec = new NotSpec(
            new OrSpec(
                new OrSpec($this->birthdaySpec, $this->dayOffSpec), $this->holidaySpec
            )
        );
    }

    public function tearDown()
    {
        OrSpec::clearErrorMessages();
    }

    public function testMyBirthday()
    {
        $this->object->date = new DateTime('1995-05-05');
        $this->assertTrue($this->birthdaySpec->isSatisfiedBy($this->object));
        $this->object->date = new DateTime('1985-05-05');
        $this->assertFalse($this->birthdaySpec->isSatisfiedBy($this->object));
    }

    public function testMyDayOff()
    {
        $this->object->date = new DateTime('2016-05-15');
        $this->assertTrue($this->dayOffSpec->isSatisfiedBy($this->object));
        $this->object->date = new DateTime('2016-05-14');
        $this->assertFalse($this->dayOffSpec->isSatisfiedBy($this->object));
    }

    public function testMyHoliday()
    {
        $this->object->date = new DateTime('2016-08-02');
        $this->assertTrue($this->holidaySpec->isSatisfiedBy($this->object));
        $this->object->date = new DateTime('2016-05-14');
        $this->assertFalse($this->holidaySpec->isSatisfiedBy($this->object));
    }

    public function testIsAvailable()
    {
        $this->object->date = new DateTime('2016-09-02');
        $this->assertTrue($this->combinedSpec->isSatisfiedBy($this->object));
        $this->assertCount(3, OrSpec::getErrorMessages());//3 errors for 3 specs
    }

    public function testNotAvailableBirthday()
    {
        $this->object->date = new DateTime('1995-05-05');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's birthday
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (day off, holiday)
    }

    public function testNotAvailableDayOff()
    {
        $this->object->date = new DateTime('2016-05-15');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's day off
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (holiday, birthday)
    }

    public function testNotAvailableHoliday()
    {
        $this->object->date = new DateTime('2016-08-02');
        $this->assertFalse($this->combinedSpec->isSatisfiedBy($this->object));//not available because it's holiday
        $this->assertCount(2, OrSpec::getErrorMessages());//2 errors for 2 specs (day off, birthday)
    }
}

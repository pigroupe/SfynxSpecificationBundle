<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;
use stdClass;

class MyHolidaySpec extends AbstractSpecification
{
    private $holiday;

    public function __construct($holidays)
    {
        $this->holiday = $holidays;
    }

    public function isSatisfiedBy(stdClass $object)
    {
        $day = $object->date;

        foreach ($this->holiday as $holiday) {
            if ($day == $holiday) {
                return true;
            }
        }

        return false;
    }
}

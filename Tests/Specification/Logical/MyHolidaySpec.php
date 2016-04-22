<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;
use DateTime;
use stdClass;

class MyHolidaySpec extends AbstractSpecification
{
    private $holiday;

    public function __construct($message)
    {
        $this->holiday = [
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
        parent::__construct($message);
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

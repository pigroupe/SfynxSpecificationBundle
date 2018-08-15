<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;
use DateTime;
use stdClass;

class MyBirthdaySpec extends AbstractSpecification
{
    private $birthday;

    public function __construct(DateTime $date)
    {
        $this->birthday = $date;
    }

    public function isSatisfiedBy(stdClass $object)
    {
        $day = $object->date;

        return $day == $this->birthday;
    }
}

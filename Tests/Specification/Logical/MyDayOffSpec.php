<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;
use stdClass;

class MyDayOffSpec extends AbstractSpecification
{
    private $tabDayOff;

    public function __construct($dayOffs)
    {
        $this->tabDayOff = $dayOffs;
    }

    public function isSatisfiedBy(stdClass $object)
    {
        $day = $object->date;

        foreach ($this->tabDayOff as $dayOff) {
            if ($day == $dayOff) {
                return true;
            }
        }

        return false;
    }
}

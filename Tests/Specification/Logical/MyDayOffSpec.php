<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;
use DateTime;
use stdClass;

class MyDayOffSpec extends AbstractSpecification
{
    private $tabDayOff;

    public function __construct($message)
    {
        $this->tabDayOff = [];
        for ($i = 1; $i <= 12; $i++) {
            $this->tabDayOff[] = new DateTime('2016-'.sprintf("%02d", $i).'-15');
        }
        parent::__construct($message);
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

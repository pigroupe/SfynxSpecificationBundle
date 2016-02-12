<?php

namespace Sfynx\SpecificationBundle\Specification\Compare;

/**
 * This file is part of the <Trigger> project.
 * true if strpos($b, $a) === 0
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Compare
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class StartsWithInsensitiveSpec extends AbstractSpecification
{
    private $specification1;
    private $specification2;

    function __construct($specification1, $specification2)
    {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy($object = null)
    {
        list($a, $b) = $this->setValues($this->specification1, $this->specification2, $object);

        return strpos($b, $a) === 0;
    }
}

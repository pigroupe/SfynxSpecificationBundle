<?php

namespace Sfynx\SpecificationBundle\Specification\Math;

/**
 * This file is part of the <Trigger> project.
 * true if $a * $b
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Math
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class MultiplySpec extends AbstractSpecification
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

        return $a * $b;
    }
}

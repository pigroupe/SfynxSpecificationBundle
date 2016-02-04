<?php

namespace Sfynx\SpecificationBundle\Specification\Math;

/**
 * This file is part of the <Trigger> project.
 * true if ceil(c)
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Math
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class CeilSpec extends AbstractSpecification
{
    private $specification1;

    function __construct($specification1)
    {
        $this->specification1 = $specification1;
    }

    public function isSatisfiedBy($object = null)
    {
        if ($this->specification1 instanceof  InterfaceSpecification) {
            $a = $this->specification1->isSatisfiedBy($object);
        } else {
            $a = $this->specification1;
        }

        return (int) ceil($a);
    }
}

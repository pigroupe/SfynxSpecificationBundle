<?php

namespace Sfynx\SpecificationBundle\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    Specification
 * @author     Laurent DE NIL <laurent.denil@gmail.com>
 */
class TrueSpecification implements InterfaceSpecification
{
    /**
     * always true
     *
     * @param $object
     * @return bool
     */
    public function isSatisfiedBy(\stdClass $object)
    {
        return true;
    }
}

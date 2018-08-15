<?php

namespace Sfynx\SpecificationBundle\Specification\Logical;

/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    Specification
 * @author     Laurent DE NIL <laurent.denil@gmail.com>
 */
class TrueSpec extends AbstractSpecification
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

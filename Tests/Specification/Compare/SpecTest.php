<?php

namespace Sfynx\SpecificationBundle\Tests\Specification\Compare;

use Sfynx\SpecificationBundle\Specification\AbstractSpecification;

/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Test
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class SpecTest extends AbstractSpecification {

    public function isSatisfiedBy(\stdClass $object)
    {
        if (strlen($object->str) >= 3) {
            return true;
        } else {
            return false;
        }
    }
}

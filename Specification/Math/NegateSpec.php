<?php

namespace Sfynx\SpecificationBundle\Specification\Math;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * return $a + $b
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Math
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class NegateSpec extends AbstractSpecification
{
    private $specification1;

    public function __construct($specification1)
    {
        $this->specification1 = $specification1;
    }

    public function isSatisfiedBy(\stdClass $object = null)
    {
        if ($this->specification1 instanceof InterfaceSpecification) {
            $a = $this->specification1->isSatisfiedBy($object);
        } else {
            $a = $this->specification1;
        }
        $result = -$a;
        static::addToProfiler([$this->getLogicalExpression() => $result]);

        return $result;
    }

    public function getLogicalExpression()
    {
        return sprintf('(-%s)', $this->specification1->getLogicalExpression());
    }
}

<?php

namespace Sfynx\SpecificationBundle\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * True if both conditions are true
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Logical
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class AndSpec extends AbstractSpecification
{
    protected $specification1;
    protected $specification2;

    public function __construct(InterfaceSpecification $specification1, InterfaceSpecification $specification2)
    {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy(\stdClass $object)
    {
        $result = $this->specification1->isSatisfiedBy($object) && $this->specification2->isSatisfiedBy($object);
        static::addToProfiler([$this->getLogicalExpression() => $result]);

        return $result;
    }

    public function getLogicalExpression()
    {
        $exp1 = $this->specification1;
        if ($this->specification1 instanceof InterfaceSpecification) {
            $exp1 = $this->specification1->getLogicalExpression();
        }

        $exp2 = $this->specification2;
        if ($this->specification2 instanceof InterfaceSpecification) {
            $exp2 = $this->specification2->getLogicalExpression();
        }

        return sprintf('(%s AND %s)', $exp1, $exp2);
    }
}

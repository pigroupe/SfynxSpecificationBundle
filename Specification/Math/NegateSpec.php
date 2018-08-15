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
    protected $specification1;

    public function __construct(InterfaceSpecification $specification1)
    {
        $this->specification1 = $specification1;
    }

    public function isSatisfiedBy(\stdClass $object)
    {
        if ($this->specification1 instanceof InterfaceSpecification) {
            $a = $this->specification1->isSatisfiedBy($object);
        } else {
            $a = $this->specification1;
        }
        $result = -($a);
        static::addToProfiler([$this->getLogicalExpression() => $result]);

        return $result;
    }

    public function getLogicalExpression()
    {
        if ($this->specification1 instanceof InterfaceSpecification) {
            $exp1 = $this->specification1->getLogicalExpression();
        } else {
            $exp1 = $this->specification1;
        }

        return sprintf('(-%s)', $exp1);
    }
}

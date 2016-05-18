<?php

namespace Sfynx\SpecificationBundle\Specification\Compare;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * true if $a == $b
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Compare
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class EqualToSpec extends AbstractSpecification
{
    private $specification1;
    private $specification2;

    public function __construct($specification1, $specification2)
    {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy(\stdClass $object = null)
    {
        list($a, $b) = $this->setValues($this->specification1, $this->specification2, $object);
        $result = ($a == $b);
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

        if ($this->specification2 instanceof InterfaceSpecification) {
            $exp2 = $this->specification2->getLogicalExpression();
        } else {
            $exp2 = $this->specification2;
        }

        return sprintf('(%s == %s)', $exp1, $exp2);
    }
}

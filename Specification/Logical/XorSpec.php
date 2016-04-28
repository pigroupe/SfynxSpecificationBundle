<?php

namespace Sfynx\SpecificationBundle\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * True if only one condition is true
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Logical
 */
class XorSpec extends AbstractSpecification
{
    private $specification1;
    private $specification2;

    public function __construct(InterfaceSpecification $specification1, InterfaceSpecification $specification2)
    {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy(\stdClass $object)
    {
        $a = $this->specification1->isSatisfiedBy($object);
        $b = $this->specification2->isSatisfiedBy($object);
        $result = ($a and !$b) || (!$a and $b);
        static::addToProfiler([$this->getLogicalExpression() => $result]);

        return $result;
    }

    public function getLogicalExpression()
    {
        return sprintf('(%s XOR %s)', $this->specification1->getLogicalExpression(), $this->specification2->getLogicalExpression());
    }
}

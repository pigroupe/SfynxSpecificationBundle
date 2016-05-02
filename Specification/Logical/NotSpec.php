<?php

namespace Sfynx\SpecificationBundle\Specification\Logical;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * True if false and false if true
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Logical
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class NotSpec extends AbstractSpecification
{
    private $specification;

    public function __construct(InterfaceSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy(\stdClass $object)
    {
        $result = $this->specification->isSatisfiedBy($object);
        static::addToProfiler([$this->specification->getLogicalExpression() => $result]);

        $result = !$result;
        static::addToProfiler([$this->getLogicalExpression() => $result]);

        return $result;
    }

    public function getLogicalExpression()
    {
        if ($this->specification instanceof InterfaceSpecification) {
            $exp1 = $this->specification->getLogicalExpression();
        } else {
            $exp1 = $this->specification;
        }

        return sprintf('NOT(%s)',$exp1);
    }
}

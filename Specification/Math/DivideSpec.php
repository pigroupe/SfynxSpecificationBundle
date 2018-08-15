<?php
namespace Sfynx\SpecificationBundle\Specification\Math;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;
use \Exception;

/**
 * This file is part of the <Trigger> project.
 * return $a / $b
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Math
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class DivideSpec extends AbstractSpecification
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
        list($a, $b) = $this->setValues($this->specification1, $this->specification2, $object);
        if ($b === 0) {
            throw new Exception('Can\'t divide by zero');
        }
        $result = $a / $b;
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

        return sprintf('(%s / %s)', $exp1, $exp2);
    }
}

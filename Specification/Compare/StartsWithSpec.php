<?php
namespace Sfynx\SpecificationBundle\Specification\Compare;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * true if stripos($a, $b) === 0
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Compare
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class StartsWithSpec extends AbstractSpecification
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
//@TODO profiler
        return stripos($a, $b) === 0;
    }

    public function getLogicalExpression()
    {
        return sprintf('(%s STARTS_WITH %s)', $this->specification1->getLogicalExpression(), $this->specification2->getLogicalExpression());
    }
}

<?php
namespace Sfynx\SpecificationBundle\Specification\Compare;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;

/**
 * This file is part of the <Trigger> project.
 * true if strpos($a, $b) === strlen($a) - strlen($b))
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Compare
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class EndsWithInsensitiveSpec extends AbstractSpecification
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
        return (strpos($a, $b) === strlen($a) - strlen($b));
    }

    public function getLogicalExpression()
    {
        return sprintf('(%s END_WITH_INSENSITIVE %s)', $this->specification1->getLogicalExpression(), $this->specification2->getLogicalExpression());
    }
}

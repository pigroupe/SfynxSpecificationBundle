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
    private $specification1;
    private $specification2;

    public function __construct(InterfaceSpecification $specification1, InterfaceSpecification $specification2) {
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function isSatisfiedBy(\stdClass $object)
    {
        $a = $this->specification1->isSatisfiedBy($object);
        if ($a === false) {
            self::addErrorMessage($this->specification1->getMessage());
        }
        $b = $this->specification2->isSatisfiedBy($object);
        if ($b === false) {
            self::addErrorMessage($this->specification2->getMessage());
        }

        return $a && $b;
    }

}

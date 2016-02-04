<?php

namespace Sfynx\SpecificationBundle\Specification\Generalisation;

/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Builder
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 *
 * <code>
 * $anyObject = new StdClass;
 * $specification =
 * new MySpecification1()
 *   ->andSpec(new MySpecification2())
 *   ->andSpec(
 *       new MySpecification3()
 *       ->orSpec(new MySpecification4())
 *   );
 * ;
 * $isOk = $specification->isSatisfedBy($anyObject);
 * <code>
 *
 */
interface InterfaceSpecification
{
    public function isSatisfiedBy($object);
}

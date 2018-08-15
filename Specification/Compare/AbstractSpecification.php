<?php

namespace Sfynx\SpecificationBundle\Specification\Compare;

use Sfynx\SpecificationBundle\Specification\Generalisation\InterfaceSpecification;
use Sfynx\SpecificationBundle\Specification\Generalisation\TraitProfiler;

/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    Specification
 * @subpackage Compare
 * @abstract
 */
abstract class AbstractSpecification implements InterfaceSpecification
{
    use TraitProfiler;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $className = '\Sfynx\SpecificationBundle\Specification\Compare\\' . $name;
        if (\class_exists($className)) {
            if (isset($arguments[0])
                && $arguments[0] instanceof InterfaceSpecification
            ) {
                return new $className($this, $arguments[0]);
            }
            return new $className($arguments[0], $arguments[1]);
        }
        throw new \Exception('The class does not existed');
    }

    /**
     * @param $specification1
     * @param $specification2
     * @param $object
     * @return array
     */
    protected function setValues($specification1, $specification2, $object)
    {
        if ($specification1 instanceof InterfaceSpecification
            && $specification2 instanceof InterfaceSpecification)
        {
            $a = $specification1->isSatisfiedBy($object);
            $b = $specification2->isSatisfiedBy($object);
        } else {
            $a = $specification1;
            $b = $specification2;
        }

        return [$a, $b];
    }
}

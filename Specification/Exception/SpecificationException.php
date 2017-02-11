<?php

namespace Sfynx\SpecificationBundle\Specification\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SpecificationException
 */
class SpecificationException extends Exception
{
    /**
     * @var array Array of data to describe errors
     */
    protected $data;

    /**
     * @param string $message
     * @param array $data
     * @param Exception|null $previous
     */
    public function __construct($message = '', array $data = [], Exception $previous = null)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $previous);
        $this->data = $data;
    }

    /**
     * Returns the <Unsatisfied Specification> Exception.
     *
     * @param $data
     * @return SpecificationException
     */
    public static function unsatisfiedSpecification($data)
    {
        return new static('Unsatisfied specifications', $data);
    }

    /**
     * Returns the <Bad Interface Specification> Exception.
     *
     * @return SpecificationException
     */
    public static function badInterfaceSpecification()
    {
        return new static('bad format specification for specHandler. It must be an InterfaceSpecification');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}

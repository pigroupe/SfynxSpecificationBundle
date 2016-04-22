<?php

namespace Sfynx\SpecificationBundle\Specification\Generalisation;

/**
 * This file is part of the <Trigger> project.
 * Add error message feature
 *
 * @category   Trigger
 * @package    Generalisation
 * @subpackage Compare
 * @author     Laurent DE NIL <laurent.denil@gmail.com>
 */
trait TraitErrorMessage
{
    /**
     * @var array
     */
    protected static $errorMessages = array();

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage = '')
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $message
     */
    public static function addErrorMessage($message)
    {
        if (null !== $message && '' !== $message) {
            self::$errorMessages[] = $message;
        }
    }

    /**
     * @return array
     */
    public static function getErrorMessages()
    {
        return self::$errorMessages;
    }

    public static function clearErrorMessages()
    {
        self::$errorMessages = [];
    }
}

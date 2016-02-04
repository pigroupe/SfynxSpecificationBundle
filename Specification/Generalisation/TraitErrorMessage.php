<?php

namespace DemoApiContext\Domain\Specification\Handler;

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
    protected $message;

    /**
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     */
    public static function addErrorMessage($message)
    {
        self::$errorMessages[] = $message;
    }

    /**
     * @return array
     */
    public static function getErrorMessages()
    {
        return self::$errorMessages;
    }
}

<?php

namespace Sfynx\SpecificationBundle\Specification\Generalisation;

trait TraitProfiler
{
    protected static $profilerStack = [];

    public function getLogicalExpression()
    {
        return end(explode('\\', get_called_class()));
    }

    public function getProfiler()
    {
        return self::$profilerStack;
    }

    public static function sgetProfiler()
    {
        return self::$profilerStack;
    }

    public static function addToProfiler(array $data)
    {
        self::$profilerStack[] = $data;
    }

    public static function resetProfiler()
    {
        self::$profilerStack = [];
    }
}

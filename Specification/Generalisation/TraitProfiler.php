<?php
namespace Sfynx\SpecificationBundle\Specification\Generalisation;

trait TraitProfiler
{
    /**
     * @var array
     */
    protected static $profilerStack = [];

    /**
     * @return mixed
     */
    public function getLogicalExpression()
    {
        $classNames = \explode('\\', \get_called_class());
        return \end($classNames);
    }

    /**
     * @return array
     */
    public function getProfiler()
    {
        return self::$profilerStack;
    }

    /**
     * @param array $data
     * @retrun void
     */
    public static function addToProfiler(array $data)
    {
        self::$profilerStack[] = $data;
    }

    /**
     * @retrun void
     */
    public static function resetProfiler()
    {
        self::$profilerStack = [];
    }
}

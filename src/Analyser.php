<?php

namespace Axm\GetSetAnnotations;

use hanneskod\classtools\Iterator\ClassIterator;
use ReflectionException;
use Symfony\Component\Finder\Finder;

/**
 * Class Analyser
 *
 * @package Axm\GetSetAnnotations
 */
class Analyser
{
    /**
     * @param $path
     *
     * @return ClassInfo[]
     * @throws ReflectionException
     */
    public static function path($path)
    {
        return self::buildClassInfosInPath($path);
    }

    /**
     * @throws ReflectionException
     */
    protected static function buildClassInfosInPath($path)
    {
        $finder = new Finder;
        $iter = new ClassIterator($finder->in($path));

        $classInfos = [];
        foreach ($iter->getClassMap() as $classname => $splFileInfo) {
            $classInfo = new ClassInfo($classname, $splFileInfo->getRealPath());
            if ($classInfo->hasMissingMethods()) {
                $classInfos[] = $classInfo;
            }
        }
        return $classInfos;
    }
}

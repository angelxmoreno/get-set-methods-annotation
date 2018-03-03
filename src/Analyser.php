<?php

namespace Axm\GetSetAnnotations;

use Symfony\Component\ClassLoader\ClassMapGenerator;

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
     * @return array
     * @throws \ReflectionException
     */
    public static function path($path)
    {
        $class_map   = ClassMapGenerator::createMap($path);
        $class_infos = [];
        foreach ($class_map as $fqn => $path) {
            $class_info = new ClassInfo($fqn);

            $class_infos[] = [
                'path'  => $class_info->getPath(),
                'class' => $class_info->getFqn(),
                'doc'   => $class_info->getDocBlock(),
            ];
        }

        return collection($class_infos)
            ->filter(function (array $row) {
                return $row['doc'] !== '';
            })->toArray();
    }
}

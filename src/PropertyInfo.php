<?php

namespace Axm\GetSetAnnotations;

use Cake\Utility\Inflector;
use Rakshazi\GetSetTrait;

/**
 * Class PropertyInfo
 *
 * @package Axm\GetSetAnnotations
 *
 * @method \ReflectionProperty getReflector()
 * @method void setReflector(\ReflectionProperty $reflector)
 * @method string getName()
 * @method void setName(string $name)
 * @method string getComment()
 * @method void setComment(string $comment)
 * @method string getType()
 * @method void setType(string $type)
 * @method bool getNeedsSetter()
 * @method void setNeedsSetter(bool $needs_setter)
 * @method bool getNeedsGetter()
 * @method void setNeedsGetter(bool $needs_getter)
 */
class PropertyInfo
{
    use GetSetTrait;

    const PATTERN_PROPERTY_TYPE = '~@var\s+([^\s]+)~i';
    /**
     * @var \ReflectionProperty
     */
    protected $reflector;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $needs_setter = false;

    /**
     * @var bool
     */
    protected $needs_getter = false;

    /**
     * PropertyInfo constructor.
     *
     * @param \ReflectionProperty $r_property
     */
    public function __construct(\ReflectionProperty $r_property)
    {
        $this->reflector = $r_property;
        $this->name      = $r_property->getName();
        $this->comment   = $r_property->getDocComment();

        preg_match(self::PATTERN_PROPERTY_TYPE, $r_property->getDocComment(), $matches);

        $this->type = count($matches) == 2
            ? $matches[1]
            : null;
    }

    public function getGetterFuncName()
    {
        return 'get' . Inflector::camelize($this->name);
    }

    public function getSetterFuncName()
    {
        return 'set' . Inflector::camelize($this->name);
    }
}

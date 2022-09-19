<?php

namespace Axm\GetSetAnnotations\Test\sampleClass;

use DateTimeInterface;

class DeltaClass
{
    /**
     * @var int
     */
    protected $integer = 1;

    /**
     * @var float
     */
    protected $float = 1.1;

    /**
     * @var double
     */
    protected $double = 1.1;

    /**
     * @var array
     */
    protected $array = [];

    /**
     * @var bool
     */
    protected $bool = true;

    /**
     * @var DateTimeInterface|null
     */
    protected $Date = null;

    protected $null = null;
}

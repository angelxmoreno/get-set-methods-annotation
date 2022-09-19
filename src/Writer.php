<?php

namespace Axm\GetSetAnnotations;

use hanneskod\classtools\Transformer\Action\NamespaceWrapper;
use hanneskod\classtools\Transformer\Reader;
use hanneskod\classtools\Transformer\Writer as ClassToolsWriter;

class Writer
{
    /**
     * @var ClassInfo[]
     */
    protected $class_infos = [];

    /**
     * @var bool
     * @TODO not yet implemented
     */
    protected $write_to_file = false;

    /**
     * @var bool
     */
    protected $show_getters = false;

    /**
     * @var bool
     */
    protected $show_setters = false;

    /**
     * @param ClassInfo[] $class_infos
     * @param bool $write_to_file
     * @param bool $show_getters
     * @param bool $show_setters
     */
    public function __construct(array $class_infos, $write_to_file, $show_getters, $show_setters)
    {
        $this->class_infos = $class_infos;
        $this->write_to_file = $write_to_file;
        $this->show_getters = $show_getters;
        $this->show_setters = $show_setters;
    }


    public function toCli()
    {
        $this->outCli(
            'Found %s classes with missing methods',
            number_format(count($this->class_infos))
        );
        foreach ($this->class_infos as $classInfo) {
            $docBlock = $classInfo->buildMissingMethodsDoc($this->show_getters, $this->show_setters);
            $this->outCli('Classname : %s', $classInfo->getFqn());
            $this->outCli('Path : %s', $classInfo->getPath());
            $this->outCli('DocBlock : %s', $docBlock);
            $this->outCli('-----------------------------------');
        }
    }

    protected function outCli($tpl, ...$params)
    {
        if (count($params) === 0) {
            $msg = $tpl;
        } else {
            $msg = vsprintf($tpl, $params);
        }

        echo $msg . PHP_EOL;
    }

    protected function writeToFile(ClassInfo $classInfo, $docBlock)
    {
        $contents = file_get_contents($classInfo->getPath());

        $reader = new Reader($contents);
        $writer = new ClassToolsWriter();
        $writer->apply(new NamespaceWrapper());

// Outputs class Bar wrapped in namespace Foo
        echo $writer->write($reader->read('Bar'));
    }
}

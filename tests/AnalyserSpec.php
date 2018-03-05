<?php

use Axm\GetSetAnnotations\Analyser;
use Symfony\Component\ClassLoader\ClassMapGenerator;

describe(Analyser::class, function () {
    it('creates a class/file mapper', function(){
        expect(ClassMapGenerator::class)
            ->toReceive('::createMap');

        Analyser::path(__DIR__);
    });
});
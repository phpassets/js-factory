<?php

namespace PhpAssets\Js\Factory;

use PhpAssets\Js\ReaderInterface;
use PhpAssets\Js\MinifierInterface;
use PhpAssets\Js\Factory\Reader\ReaderResolver;
use PhpAssets\Js\Factory\Compiler\CompilerResolver;

class Factory
{
    /**
     * Compiler resolver instance.
     * 
     * @var \PhpAssets\Js\Factory\Compiler\CompilerResolver
     */
    protected $compilerResolver;

    /**
     * File interpreter resolver instance.
     *
     * @var \PhpAssets\Js\Factory\Reader\ReaderResolver
     */
    protected $readerResolver;

    /**
     * Default minifier instance.
     *
     * @var \PhpAssets\Js\MinifierInterface
     */
    protected $minifier;

    /**
     * Create new Factory instance.
     *
     * @param CompilerResolver $compilerResolver
     * @param ReaderResolver $readerResolver
     * @param MinifierInterface $minifier
     */
    public function __construct(
        CompilerResolver $compilerResolver,
        ReaderResolver $readerResolver,
        MinifierInterface $minifier = null
    ) {
        $this->compilerResolver = $compilerResolver;
        $this->readerResolver = $readerResolver;
        $this->minifier = $minifier;
    }

    /**
     * Create new Style instance from path.
     *
     * @param string $path
     * @param MinifierInterface $minifier
     * @return \PhpAssets\Js\Factory\Script
     */
    public function make(string $path, MinifierInterface $minifier = null)
    {
        $reader = $this->readerResolver->resolve($path);

        $lang = $this->getLang($path, $reader);

        $compiler = $this->compilerResolver->resolve($lang);

        $minifier = $minifier === null ? $this->minifier : $minifier;

        return new Script($path, $lang, $compiler, $reader, $this->minifier);
    }

    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @param \PhpAssets\Js\ReaderInterface $reader
     * @return string
     */
    public function getLang($path, ReaderInterface $reader)
    {
        return $reader->lang($path);
    }
}

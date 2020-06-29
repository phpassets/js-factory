<?php

namespace PhpAssets\Js\Factory\Compiler;

use PhpAssets\Js\CompilerInterface;

class JsCompiler implements CompilerInterface
{
    /**
     * Compile raw javascript or extension string.
     *
     * @param string $raw
     * @return string
     */
    public function compile($raw)
    {
        return $raw;
    }
}

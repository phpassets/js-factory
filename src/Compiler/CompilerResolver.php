<?php

namespace PhpAssets\Js\Factory\Compiler;

use Closure;
use InvalidArgumentException;

class CompilerResolver
{
    /**
     * The array of compiler resolvers.
     *
     * @var array
     */
    protected $resolvers = [];

    /**
     * The resolved engine instances.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a new compiler resolver by script extension language name.
     *
     * @param  string  $extension
     * @param  \Closure  $resolver
     * @return void
     */
    public function register($lang, Closure $resolver)
    {
        unset($this->resolved[$lang]);

        $this->resolvers[$lang] = $resolver;
    }

    /**
     * Resolve an compiler instance by CSS extension language name.
     *
     * @param  string  $lang
     * @return \PhpAssets\Js\CompilerInterface
     *
     * @throws \InvalidArgumentException
     */
    public function resolve($lang)
    {
        if (isset($this->resolved[$lang])) {
            return $this->resolved[$lang];
        }

        if (isset($this->resolvers[$lang])) {
            return $this->resolved[$lang] = call_user_func($this->resolvers[$lang]);
        }

        throw new InvalidArgumentException("Compiler for javacript extension language [{$lang}] not found.");
    }
}

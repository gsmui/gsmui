<?php

namespace GsmuiPro;

/**
 * Fluent class-list builder returned by Gsmui::classes().
 *
 * Blade templates across the package call:
 *   Gsmui::classes()->add('...')->add('...')
 *   Gsmui::classes()->merge(['a' => $cond, 'b' => true])
 *
 * Renderable via __toString() so it can be passed straight to
 * $attributes->class() or interpolated into a class attribute.
 */
class ClassBuilder
{
    /** @var array<int, string> */
    protected array $classes = [];

    public function __construct(array|string $classes = [])
    {
        $this->merge($classes);
    }

    /**
     * Append one class, or a list of classes. Falsy values are ignored.
     */
    public function add(string|array|null ...$classes): static
    {
        foreach ($classes as $class) {
            if ($class === null || $class === '') {
                continue;
            }

            if (is_array($class)) {
                foreach ($class as $item) {
                    $this->add($item);
                }
                continue;
            }

            $this->classes[] = $class;
        }

        return $this;
    }

    /**
     * Append classes keyed by class name and gated by a truthy value.
     *
     * Accepts either a plain list (['a', 'b']) or a map (['a' => $cond]).
     */
    public function merge(array|string|null $classes): static
    {
        if ($classes === null || $classes === '') {
            return $this;
        }

        if (is_string($classes)) {
            return $this->add($classes);
        }

        foreach ($classes as $key => $value) {
            if (is_int($key)) {
                $this->add($value);
            } elseif ($value) {
                $this->add($key);
            }
        }

        return $this;
    }

    /**
     * Append one class only when the condition is truthy.
     */
    public function addWhen(bool $condition, ?string $class): static
    {
        if ($condition) {
            $this->add($class);
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function all(): array
    {
        return $this->classes;
    }

    /**
     * Array access for templates that splat classes into a class list.
     *
     * @return array<int, string>
     */
    public function toArray(): array
    {
        return $this->classes;
    }

    public function __toString(): string
    {
        return implode(' ', $this->classes);
    }
}

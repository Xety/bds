<?php
namespace BDS\Settings;

use Countable;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use OutOfBoundsException;

class Context implements Arrayable, Countable
{
    protected array $arguments = [];

    public function __construct(array $arguments = [])
    {
        foreach ($arguments as $name => $value) {
            $this->set(name: $name, value: $value);
        }
    }

    public function get(string $name)
    {
        if (! $this->has($name)) {
            throw new OutOfBoundsException(
                sprintf('"%s" is not part of the context.', $name)
            );
        }

        return $this->arguments[$name];
    }

    public function has(string $name): bool
    {
        return isset($this->arguments[$name]);
    }

    public function remove(string $name): self
    {
        unset($this->arguments[$name]);

        return $this;
    }

    public function set(string $name, $value): self
    {
        $this->ensureValidValue($name, $value);

        $this->arguments[$name] = $value;

        return $this;
    }

    public function count(): int
    {
        return count($this->arguments);
    }

    public function toArray(): array
    {
        return $this->arguments;
    }

    /**
     * @throws \Throwable
     */
    protected function ensureValidValue(string $key, mixed $value): void
    {
        throw_unless(
            is_string($value) || is_numeric($value) || is_bool($value) || is_null($value),
            new Exception("An invalid context value was provided for key: {$key}. Only string, integer, and boolean values are allowed.", 500)
        );
    }
}

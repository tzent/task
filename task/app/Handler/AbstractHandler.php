<?php

declare(strict_types=1);

namespace App\Handler;

use Illuminate\Support\MessageBag;

abstract class AbstractHandler
{
    /**
     * @var MessageBag
     */
    protected MessageBag $errors;

    public function __construct()
    {
        $this->errors = new MessageBag();
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }

    /**
     * @return MessageBag
     */
    public function getErrors(): MessageBag
    {
        return $this->errors;
    }

    /**
     * @param $key
     * @param $message
     * @return $this
     */
    public function addError($key, $message): self
    {
        $this->errors->add($key, $message);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstError(): ?string
    {
        return $this->hasErrors() ? $this->errors->first() : null;
    }
}

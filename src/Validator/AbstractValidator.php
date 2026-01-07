<?php

declare(strict_types=1);

namespace App\Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    protected bool $valid = false;
    protected int $code = 0;
    protected ?string $message = null;

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setInvalid(string $message, int $code = 0): static
    {
        $this->valid = false;
        $this->message = $message;
        $this->code = $code;

        return $this;
    }

    public function setValid(): static
    {
        $this->valid = true;
        $this->message = null;
        $this->code = 0;

        return $this;
    }
}

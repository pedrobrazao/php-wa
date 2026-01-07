<?php

declare(strict_types=1);

namespace App\Validator;

interface ValidatorInterface
{
    public function isValid(): bool;
    public function getCode(): int;
    public function getMessage(): ?string;
}

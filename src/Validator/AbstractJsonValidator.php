<?php

declare(strict_types=1);

namespace App\Validator;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractJsonValidator extends AbstractValidator
{
    abstract public function validate(string $json): self;
}

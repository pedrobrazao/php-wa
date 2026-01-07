<?php

declare(strict_types=1);

namespace App\Validator;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractRequestValidator extends AbstractValidator
{
    abstract public function validate(ServerRequestInterface $request): static;
}

<?php
namespace Validators;

use Respect\Validation\Exceptions\NestedValidationException;

abstract class Validator
{
    abstract public function validate(array $data);
}
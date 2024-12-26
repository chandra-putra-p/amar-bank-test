<?php

namespace Validators;

abstract class Validator
{
    abstract public function validate(array $data);
}

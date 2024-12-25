<?php

namespace Validators;

use Validators\Validator;
use Respect\Validation\Validator as v;
use DateTime;

class LoanValidator extends Validator
{
    public function validate(array $data)
    {
        $validator = v::key('name', v::stringType()->notEmpty()::callback(function ($name) {
            $words = array_filter(explode(' ', trim($name)));
            return count($words) >= 2;
        })->setTemplate('{{name}} must contain at least two names (first and last name)'))
            ->key('ktpNumber', v::stringType()->notEmpty())
            ->key('loanAmount', v::intVal()->between(1000, 10000))
            ->key('loanPeriod', v::intVal()->min(1))
            ->key('loanPurpose', v::stringType()->containsAny([
                'vacation',
                'renovation',
                'electronics',
                'wedding',
                'rent',
                'car',
                'investment',
            ]))
            ->key('dob', v::stringType()->notEmpty()->date('d-m-Y'))
            ->key('gender', v::stringType()->notEmpty()->in(['MALE', 'FEMALE']))
            ->allOf(
                v::key('dob', v::stringType()->notEmpty()->date('d-m-Y')),
                v::key('gender', v::stringType()->notEmpty()->in(['MALE', 'FEMALE'])),
                v::key('ktpNumber', v::callback(function ($ktpNumber) use ($data) {
                    $dob = DateTime::createFromFormat('d-m-Y', $data['dob']);
                    $date = $dob->format('d');
                    if ($data['gender'] == 'FEMALE') {
                        $date = $date + 40;
                    }
                    $dobFormatted = $date . $dob->format('my');

                    return substr($ktpNumber, 6, 6) == $dobFormatted;
                })->setTemplate('{{name}} must be in valid format')),
            );

        $validator->assert($data);
    }
}

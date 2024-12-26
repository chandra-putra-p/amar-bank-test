<?php

namespace Tests\Validators;

use Respect\Validation\Exceptions\NestedValidationException;
use Tests\BaseTest;
use Validators\LoanValidator;

class LoanValidatorTest extends BaseTest
{
    private $data;
    private $validator;
    protected function setUp(): void
    {
        $this->data = [
            "name" => "John Doe",
            "ktpNumber" => "1122330103884455",
            "loanAmount" => 1000,
            "loanPeriod" => 1,
            "loanPurpose" => "wedding party",
            "dob" => "01-03-1988",
            "gender" => "MALE"
        ];

        $this->validator = new LoanValidator();
    }

    public function testValidData()
    {
        $this->expectNotToPerformAssertions();
        $this->validator->validate($this->data);
    }

    public function testInvalidName()
    {
        try {
            $this->data["name"] = "John";
            $this->validator->validate($this->data);
        } catch (NestedValidationException $th) {
            $errors = $th->getMessages();
            $this->assertEquals('name must contain at least two names (first and last name)', $errors["name"]);
        }
    }

    public function testInvalidKtpNumber()
    {
        try {
            $this->data["ktpNumber"] = "1122330103894455";
            $this->validator->validate($this->data);
        } catch (NestedValidationException $th) {
            $errors = $th->getMessages();
            $this->assertEquals('ktpNumber must be in valid format', $errors["allOf"]);
        }
    }

    public function testInvalidFormatDob()
    {
        try {
            $this->data["dob"] = "01-30-1999";
            $this->validator->validate($this->data);
        } catch (NestedValidationException $th) {
            $errors = $th->getMessages();
            $this->assertEquals('dob must be a valid date in the format "30-12-2005"', $errors["dob"]);
        }
    }
}

<?php

namespace Models;

use Ramsey\Uuid\Uuid;

class Loan
{
    public readonly string $id;
    public readonly string $timestamp;

    public function __construct(
        public readonly string $name,
        public readonly string $ktpNumber,
        public readonly float $loanAmount,
        public readonly int $loanPeriod,
        public readonly string $loanPurpose,
        public readonly string $dob,
        public readonly string $gender,
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->timestamp = date('Y-m-d H:i:s');
    }
}

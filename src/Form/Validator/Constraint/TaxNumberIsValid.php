<?php

namespace App\Form\Validator\Constraint;

use App\Form\Validator\TaxNumberIsValidValidator;
use Symfony\Component\Validator\Constraint;

class TaxNumberIsValid extends Constraint
{
    public string $message = 'Invalid tax number';

    public function validatedBy(): string
    {
        return TaxNumberIsValidValidator::class;
    }
}

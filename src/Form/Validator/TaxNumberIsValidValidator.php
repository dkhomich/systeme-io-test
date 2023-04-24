<?php

namespace App\Form\Validator;

use App\Form\Validator\Constraint\TaxNumberIsValid;
use App\Service\TaxCalculatorService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberIsValidValidator extends ConstraintValidator
{
    public function __construct(
        private readonly TaxCalculatorService $taxCalculatorService
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /** @var TaxNumberIsValid $constraint */
        if (empty($value) || !$this->taxCalculatorService->getCountryByTaxNumber(strval($value))) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}

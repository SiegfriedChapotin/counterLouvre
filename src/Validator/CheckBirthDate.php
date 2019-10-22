<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckBirthDate extends Constraint
{
    public function validatedBy()
    {
        return CheckBirthDateValidator::class;
    }
}
<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */

class HolidayDateConstraint extends Constraint
{
    public function validatedBy()
    {
        return HolidayDateValidator::class;
    }
}

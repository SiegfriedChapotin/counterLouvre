<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullDayConstraint extends Constraint
{
    public function validatedBy()
    {
        return FullDayValidator::class;
    }
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
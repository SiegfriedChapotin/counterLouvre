<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BirthDayConstraint extends Constraint
{
    public function validatedBy()
    {
        return BirthDayValidator::LIMIT;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}


<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class CheckDateValidator extends ConstraintValidator
{


    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        // This dates are not valid
        $forbiddenDates = [
            '0105',
            '0111',
            '2512',
        ];

        $dateToString = $value->format('dmY');
        // Delete years
        $InputDate = substr($dateToString,0,4);


        // if booking_date not valid
        if (in_array($InputDate, $forbiddenDates)){
            $this->context->addViolation($constraint->message);
        }

    }
}
<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BirthDayValidator extends ConstraintValidator
{
    const LIMIT = 4;

    public function validate($value, Constraint $constraint)
    {
    /* @var $constraint BirthDayConstraint */

    $today = new \DateTime();
    $age = $today->diff($value)->format('d-m-Y');

    if ((int)$age < self::LIMIT ){
        $this->context->buildViolation('Rappel! L\'entrée est gratuite pour les enfants de moin de 4ans.Veuillez entrer une date valide')->addViolation();
    }

   }
}

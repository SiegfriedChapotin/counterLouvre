<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CheckBirthDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CheckBirthDate) {
            throw new UnexpectedTypeException($constraint, CheckBirthDate::class);
        }

        if (empty($value)) {
            return;
        }

        if (!$value instanceof \DateTime) {
            $this->context->buildViolation('Date non valide')->addViolation();
        }

        $today = new \DateTime();
        $today->setTime(0, 0, 0, 0);
        if ($value < $today) {
            $this->context->buildViolation('La date doit être ultérieur ou égal à aujourd\'hui')->addViolation();
        }
    }
}
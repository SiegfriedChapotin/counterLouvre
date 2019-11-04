<?php


namespace App\Validator;

use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @Annotation
 */
class FullDayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FullDayConstraint) {
            throw new UnexpectedTypeException($constraint, FullDayConstraint::class);
        }

        if (empty($value)) {
            return;
        }

        if (!$value instanceof Booking) {
            throw new LogicException('The class should be ' . Booking::class . ' and not ' . get_class($value));
        }

        if ($value->getPeriod()) {
            $now = new \DateTime();
            if ($value->getEntry()->format('d-m-Y') === $now->format('d-m-Y')) {
                $midday = new \DateTime();
                $midday = $midday->setTime(12, 0, 0, 0);

                if ($now >= $midday) {
                    $this->context->buildViolation('Pas possible de réserver un billet "jours complet" l\'après midi du jour même.')->addViolation();
                }
            }
        }
    }
}
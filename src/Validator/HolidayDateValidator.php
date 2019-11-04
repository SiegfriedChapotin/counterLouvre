<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class HolidayDateValidator
 * @package App\Validator
 */

class HolidayDateValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {
        $year = intval($date->format('Y'));
        $timestamp = $date->getTimestamp();

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = array(
            // Dates fixes
            mktime(0, 0, 0, 1, 1, $year),  // 1er janvier
            mktime(0, 0, 0, 5, 1, $year),  // Fête du travail
            mktime(0, 0, 0, 5, 8, $year),  // Victoire des alliés
            mktime(0, 0, 0, 7, 14, $year),  // Fête nationale
            mktime(0, 0, 0, 8, 15, $year),  // Assomption
            mktime(0, 0, 0, 11, 1, $year),  // Toussaint
            mktime(0, 0, 0, 11, 11, $year),  // Armistice
            mktime(0, 0, 0, 12, 25, $year),  // Noel

            // Dates variables
            mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear), //Pâques
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear), // Ascension
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
        );

        if (in_array($timestamp, $holidays)) {
            $this->context->buildViolation("It is not possible to book for public holidays")
                ->addViolation();
        }

    }

}
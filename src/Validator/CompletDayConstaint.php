<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class CompletDayConstaint
 * @package APP\Validator
 * @Annotation()
 */
class CompletDayConstaint extends Constraint
{

    public function validatedBy()
    {
        return CompletDayValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}

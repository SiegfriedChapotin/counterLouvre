<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AllowFullDay extends Constraint
{
    public $message = "app.full_day.not_available";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
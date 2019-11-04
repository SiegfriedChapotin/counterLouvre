<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EntryDateConstraint extends Constraint
{
    public function validatedBy()
    {
        return EntryDateValidator::class;
    }


}
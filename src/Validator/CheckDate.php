<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckDate extends Constraint
{
    public $message = "Le musée est fermé les 1er Mai, 1er Novembre et 25 décembre, veuillez choisir une autre date.";
}
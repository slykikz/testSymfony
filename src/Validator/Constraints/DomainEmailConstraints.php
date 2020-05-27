<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class DomainEmailConstraints extends Constraint
{
public $message = 'Impossible cet email est pas valable';
}
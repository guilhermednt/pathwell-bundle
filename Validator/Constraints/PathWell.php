<?php

namespace Donato\PathWellBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class PathWell
 * @package Donato\PathWellBundle\Validator\Constraints
 * @Annotation
 */
class PathWell extends Constraint
{
    public $message = "pathwell.weak_password";

    public function validatedBy()
    {
        return 'pathwell_validator';
    }


}

<?php

namespace Gdbots\Pbjc\Validator\Constraints;

use Gdbots\Pbjc\Exception\ValidatorException;
use Gdbots\Pbjc\Validator\ConstraintInterface;
use Gdbots\Pbjc\SchemaDescriptor;

class RequireAddtionalFieldConstraint implements ConstraintInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(SchemaDescriptor $a, SchemaDescriptor $b)
    {
    }
}

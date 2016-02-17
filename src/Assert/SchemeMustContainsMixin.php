<?php

namespace Gdbots\Pbjc\Assert;

use Gdbots\Pbjc\Exception\ValidatorException;
use Gdbots\Pbjc\SchemaDescriptor;

class SchemeMustContainsMixin implements Assert
{
    /**
     * {@inheritdoc}
     */
    public function validate(SchemaDescriptor $a, SchemaDescriptor $b)
    {
        $diff = array_diff(
            array_keys($a->getMixins()),
            array_keys($b->getMixins())
        );
        if (count($diff)) {
            throw new ValidatorException(sprintf(
                'The schema "%s" must include the following mixin(s): "%s".',
                $b,
                implode('", "', $diff)
            ));
        }
    }
}
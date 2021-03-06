<?php

namespace Gdbots\Pbjc\Type;

use Gdbots\Pbj\WellKnown\Microtime;

final class MicrotimeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getDefault()
    {
        return Microtime::create();
    }

    /**
     * {@inheritdoc}
     */
    public function isNumeric()
    {
        return true;
    }
}

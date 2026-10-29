<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\SchemaIsMixin;
use PHPUnit\Framework\TestCase;

class SchemaIsMixinTest extends TestCase
{
    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['is-mixin' => true]);
        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['is-mixin' => true]);

        $asset = new SchemaIsMixin();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['is-mixin' => true]);
        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1');

        $asset = new SchemaIsMixin();
        $asset->validate($a, $b);
    }
}

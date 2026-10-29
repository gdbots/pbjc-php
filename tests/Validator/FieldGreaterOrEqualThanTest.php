<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\FieldGreaterOrEqualThan;
use PHPUnit\Framework\TestCase;

class FieldGreaterOrEqualThanTest extends TestCase
{
    public function testValidateNoConfig()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
            ]),
        ]]);

        $asset = new FieldGreaterOrEqualThan();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 100,
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 100,
            ]),
        ]]);

        $asset = new FieldGreaterOrEqualThan();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateLessThan()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 100,
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 1000,
            ]),
        ]]);

        $asset = new FieldGreaterOrEqualThan();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 100,
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
                'max'  => 10,
            ]),
        ]]);

        $asset = new FieldGreaterOrEqualThan();
        $asset->validate($a, $b);
    }
}

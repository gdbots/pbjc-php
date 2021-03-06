<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\EnumDescriptor;
use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\FieldSameEnum;

class FieldSameEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'enum' => new EnumDescriptor('vendor:package:e1', 'string', []),
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'enum' => new EnumDescriptor('vendor:package:e1', 'string', []),
            ]),
        ]]);

        $asset = new FieldSameEnum();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    /**
     * @expectedException \Gdbots\Pbjc\Exception\ValidatorException
     */
    public function testValidateException()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'enum' => new EnumDescriptor('vendor:package:e1', 'string', []),
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'enum' => new EnumDescriptor('vendor:package:e2', 'string', []),
            ]),
        ]]);

        $asset = new FieldSameEnum();
        $asset->validate($a, $b);
    }
}

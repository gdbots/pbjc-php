<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\Enum\FieldRule;
use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\FieldAttributeEqualTo;
use PHPUnit\Framework\TestCase;

class FieldAttributeEqualToTest extends TestCase
{
    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
            ]),
        ]]);

        $asset = new FieldAttributeEqualTo('type');
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'int',
            ]),
        ]]);

        $asset = new FieldAttributeEqualTo('type');
        $asset->validate($a, $b);
    }

    public function testValidateFieldRuleException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'rule' => FieldRule::A_SET,
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type' => 'string',
                'rule' => FieldRule::A_LIST,
            ]),
        ]]);

        $asset = new FieldAttributeEqualTo('rule');
        $asset->validate($a, $b);
    }
}

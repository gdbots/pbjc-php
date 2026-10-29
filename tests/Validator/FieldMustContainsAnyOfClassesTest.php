<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\FieldMustContainsAnyOfClasses;
use PHPUnit\Framework\TestCase;

class FieldMustContainsAnyOfClassesTest extends TestCase
{
    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type'   => 'string',
                'any-of' => [
                    new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
                ],
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type'   => 'string',
                'any-of' => [
                    new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
                ],
            ]),
        ]]);

        $asset = new FieldMustContainsAnyOfClasses();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type'   => 'string',
                'any-of' => [
                    new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
                ],
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type'   => 'string',
                'any-of' => [
                    new SchemaDescriptor('pbj:vendor3:package3:category3:message3:1-0-0'),
                ],
            ]),
        ]]);

        $asset = new FieldMustContainsAnyOfClasses();
        $asset->validate($a, $b);
    }
}

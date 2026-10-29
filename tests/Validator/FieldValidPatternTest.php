<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\FieldValidPattern;
use PHPUnit\Framework\TestCase;

class FieldValidPatternTest extends TestCase
{
    public function testValidateSame()
    {
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type'    => 'string',
                'pattern' => '/^[A-Za-z0-9_\-]+$/',
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type'    => 'string',
                'pattern' => '/^[A-Za-z0-9_\-]+$/',
            ]),
        ]]);

        $asset = new FieldValidPattern();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['fields' => [
            new FieldDescriptor('f1', [
                'type'    => 'string',
                'pattern' => '/^[A-Za-z0-9_\-]+$/',
            ]),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['fields' => [
            new FieldDescriptor('f1', [
                'type'    => 'string',
                'pattern' => 'invalid regex/',
            ]),
        ]]);

        $asset = new FieldValidPattern();
        $asset->validate($a, $b);
    }
}

<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\SchemaId;
use Gdbots\Pbjc\SchemaStore;
use Gdbots\Pbjc\Validator\SchemaMixinsMustContainsMixin;
use PHPUnit\Framework\TestCase;

class SchemaMixinsMustContainsMixinTest extends TestCase
{
    public function testValidateSame()
    {
        SchemaStore::addSchema(
            SchemaId::fromString('pbj:vendor2:package2:category2:message2:1-0-0'),
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0', ['is-mixin' => true])
        );

        $m = new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0', ['is-mixin' => true]);

        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['mixins' => [$m]]);
        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['mixins' => [$m]]);

        $asset = new SchemaMixinsMustContainsMixin();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function xxtestValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        SchemaStore::addSchema(
            SchemaId::fromString('pbj:vendor2:package2:category2:message2:1-0-1'),
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-1', ['is-mixin' => true])
        );

        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0',
            [
                'mixins' => [
                    new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0', ['is-mixin' => true]),
                ],
            ]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1',
            [
                'mixins' => [
                    new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-1'),
                ],
            ]);

        $asset = new SchemaMixinsMustContainsMixin();
        $asset->validate($a, $b);
    }
}

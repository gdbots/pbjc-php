<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\SchemaId;
use Gdbots\Pbjc\SchemaStore;
use Gdbots\Pbjc\Validator\SchemaMustContainsMixin;
use PHPUnit\Framework\TestCase;

class SchemaMustContainsMixinTest extends TestCase
{
    public function testValidateSame()
    {
        SchemaStore::addSchema(
            SchemaId::fromString('pbj:vendor2:package2:category2:message2:1-0-0'),
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0')
        );

        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['mixins' => [
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['mixins' => [
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
        ]]);

        $asset = new SchemaMustContainsMixin();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateAddon()
    {
        SchemaStore::addSchema(
            SchemaId::fromString('pbj:vendor2:package2:category2:message2:1-0-0'),
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0')
        );
        SchemaStore::addSchema(
            SchemaId::fromString('pbj:vendor3:package3:category3:message3:1-0-0'),
            new SchemaDescriptor('pbj:vendor3:package3:category3:message3:1-0-0')
        );

        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['mixins' => [
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['mixins' => [
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
            new SchemaDescriptor('pbj:vendor3:package3:category3:message3:1-0-0'),
        ]]);

        $asset = new SchemaMustContainsMixin();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function xxtestValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['mixins' => [
            new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0'),
        ]]);

        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['mixins' => [
            new SchemaDescriptor('pbj:vendor3:package3:category3:message3:1-0-0'),
        ]]);

        $asset = new SchemaMustContainsMixin();
        $asset->validate($a, $b);
    }
}

<?php

namespace Gdbots\Tests\Pbjc\Validator;

use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Validator\SchemaValidExtends;
use PHPUnit\Framework\TestCase;

class SchemaValidExtendsTest extends TestCase
{
    public function testValidateSame()
    {
        $m = new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0');

        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['extends' => $m]);
        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['extends' => $m]);

        $asset = new SchemaValidExtends();
        $asset->validate($a, $b);

        $this->assertTrue(true);
    }

    public function testValidateException()
    {
        $this->expectException(\Gdbots\Pbjc\Exception\ValidatorException::class);
        $a = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-0', ['extends' => new SchemaDescriptor('pbj:vendor2:package2:category2:message2:1-0-0')]);
        $b = new SchemaDescriptor('pbj:vendor:package:category:message:1-0-1', ['extends' => new SchemaDescriptor('pbj:vendor3:package3:category3:message3:1-0-0')]);

        $asset = new SchemaValidExtends();
        $asset->validate($a, $b);
    }
}

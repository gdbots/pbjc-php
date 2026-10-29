<?php

namespace Gdbots\Tests\Pbjc;

use Gdbots\Pbjc\EnumDescriptor;
use Gdbots\Pbjc\EnumParser;
use Gdbots\Pbjc\Util\LanguageBag;
use PHPUnit\Framework\TestCase;
use TypeError;

class EnumParserTest extends TestCase
{
    public function testFromFile()
    {
        $languageBag = new LanguageBag([
//            'php' => new LanguageBag(),
//            'js'  => new LanguageBag(),
        ]);

        $enums = [
            new EnumDescriptor('acme:blog:publish-status', 'string', [
                'UNKNOWN'   => 'unknown',
                'PUBLISHED' => 'published',
                'DRAFT'     => 'draft',
                'PENDING'   => 'pending',
                'EXPIRED'   => 'expired',
                'DELETED'   => 'deleted',
            ], $languageBag),

            new EnumDescriptor('acme:blog:content-type', 'string', [
                'UNKNOWN' => 'unknown',
                'ARTICLE' => 'article',
                'LINK'    => 'link',
                'PHOTO'   => 'photo',
                'QUOTE'   => 'quote',
                'TEXT'    => 'text',
                'VIDEO'   => 'video',
            ], $languageBag),
        ];

        $parser = new EnumParser();
        $this->assertEquals($parser->fromFile(__DIR__ . '/Fixtures/schemas/acme/blog/enums.xml'), $enums);
    }

    public function testFromFileException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $parser = new EnumParser();
        $parser->fromFile(__DIR__ . '/Fixtures/missing_enum_type.xml');
    }
}

<?php

namespace Gdbots\Tests\Pbjc;

use JsonSchema\Uri\UriResolver;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JsonValidatorTest extends TestCase
{
    #[DataProvider('getSchemas')]
    public function testValidateSchema($data)
    {
        if (is_string($data)) {
            $data = json_decode(file_get_contents($data));
        }

        // get the schema and data as objects
        $retriever = new UriRetriever();
        $schema = $retriever->retrieve('http://json-schema.org/draft-04/schema#');

        // resolve $ref's
        //$refResolver = new UriResolver($retriever);
        //$refResolver->resolve($schema, __DIR__ . '/Fixtures');

        // validate
        $validator = new Validator();
        $validator->check($data, $schema);

        $this->assertTrue(0 === $validator->check($data, $schema));
    }

    public static function getSchemas(): array
    {
        return [
            [
                'data' => __DIR__ . '/Fixtures/json-schema/article.json',
            ],
            [
                'data' => __DIR__ . '/Fixtures/json-schema/comment.json',
            ],
            [
                'data' => (object)[
                    'id'                   => 'file://schame.json#',
                    '$schema'              => 'http://json-schema.org/draft-04/schema#',
                    'type'                 => 'object',
                    'properties'           => (object)[
                        '_schema' => (object)[
                            'type'    => 'string',
                            'pattern' => '^pbj:([a-z0-9-]+):([a-z0-9\\.-]+):([a-z0-9-]+)?:([a-z0-9-]+):([0-9]+-[0-9]+-[0-9]+)$',
                            'default' => 'pbj:acme:blog:entity:manual-schema:1-0-0',
                        ],
                    ],
                    'additionalProperties' => false,
                ],
            ],
            [
                'data' => (object)[
                    'id'                   => 'file://schame.json#',
                    '$schema'              => 'http://json-schema.org/draft-04/schema#',
                    'type'                 => 'object',
                    'properties'           => (object)[
                        'tags' => (object)[
                            'type'        => 'array',
                            'items'       => (object)[
                                (object)[
                                    'type' => 'string',
                                ],
                            ],
                            'minItems'    => 1,
                            'uniqueItems' => true,
                        ],
                    ],
                    'additionalProperties' => false,
                ],
            ],
        ];
    }
}

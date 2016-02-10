<?php

namespace Acme\Schemas\Blog\Entity;

use Gdbots\Pbj\AbstractMixin;
use Gdbots\Pbj\FieldBuilder as Fb;
use Gdbots\Pbj\SchemaId;
use Gdbots\Pbj\Type as T;
use Gdbots\Pbj\Enum\Format;
use Gdbots\Identifiers\UuidIdentifier;

final class CommentV1Mixin extends AbstractMixin
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return SchemaId::fromString('pbj:acme:blog:entity:comment:1-0-0');
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return [
            Fb::create('_id', T\IdentifierType::create())
                ->required()
                ->withDefault(function() {
                return UuidIdentifier::generate();
              })
                ->className('Gdbots\Identifiers\UuidIdentifier')
                ->build(),
            Fb::create('comment', T\TextType::create())
                ->build(),
            Fb::create('published_at', T\MicrotimeType::create())
                ->build()
          ];
    }
}
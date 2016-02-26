<?php

namespace Acme\Schemas\Blog\Enum;

use Gdbots\Common\Enum;

/**
 * @method static ContentType ARTICLE()
 * @method static ContentType LINK()
 * @method static ContentType PHOTO()
 * @method static ContentType QUOTE()
 * @method static ContentType TEXT()
 * @method static ContentType UNKNOWN()
 * @method static ContentType VIDEO()
 */
final class ContentType extends Enum
{
    const ARTICLE = 'article';
    const LINK = 'link';
    const PHOTO = 'photo';
    const QUOTE = 'quote';
    const TEXT = 'text';
    const UNKNOWN = 'unknown';
    const VIDEO = 'video';
}
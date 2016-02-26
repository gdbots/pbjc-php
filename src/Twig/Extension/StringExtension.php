<?php

namespace Gdbots\Pbjc\Twig\Extension;

use Gdbots\Common\Util\StringUtils;

class StringExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getClass', array($this, 'getClass')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('reduceSpaces', array($this, 'reduceSpaces')),
            new \Twig_SimpleFilter('toCamelFromSlug', array($this, 'toCamelFromSlug')),
        );
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function getClass($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public function reduceSpaces($str)
    {
        return preg_replace('/\s+/', ' ', $str);
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    public function toCamelFromSlug($slug)
    {
        return StringUtils::toCamelFromSlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'string';
    }
}

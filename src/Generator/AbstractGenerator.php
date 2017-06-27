<?php

namespace Gdbots\Pbjc\Generator;

use Gdbots\Common\Util\StringUtils;
use Gdbots\Pbjc\CompileOptions;
use Gdbots\Pbjc\EnumDescriptor;
use Gdbots\Pbjc\FieldDescriptor;
use Gdbots\Pbjc\Generator\Twig\StringExtension;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\Util\OutputFile;

abstract class AbstractGenerator implements Generator
{
    const TEMPLATE_DIR = __DIR__ . '/Twig/';
    const LANGUAGE = 'unknown';
    const EXTENSION = '.unk';

    /** @var CompileOptions */
    protected $compileOptions;

    /** @var \Twig_Environment */
    protected $twig;

    /**
     * @param CompileOptions $compileOptions
     */
    public function __construct(CompileOptions $compileOptions)
    {
        $this->compileOptions = $compileOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function generateSchema(SchemaDescriptor $schema)
    {
        $response = new GeneratorResponse();

        foreach ($schema->getFields() as $field) {
            $this->updateFieldOptions($schema, $field);
        }

        if ($schema->isMixinSchema()) {
            $this->generateMixin($schema, $response);
            $this->generateMixinInterface($schema, $response);
            $this->generateMixinMajorInterface($schema, $response);
            $this->generateTrait($schema, $response);
        } else {
            $this->generateMessage($schema, $response);
            $this->generateMessageInterface($schema, $response);
        }

        return $response;
//
//        foreach ($this->getSchemaTemplates($schema) as $template => $filename) {
//            $response->addFile($this->renderFile(
//                $template,
//                $this->getSchemaTarget($schema, $filename),
//                $this->getSchemaParameters($schema)
//            ));
//        }
//
//        if ($schema->isLatestVersion()) {
//            foreach ($this->getSchemaTemplates($schema) as $template => $filename) {
//                if ($this->getSchemaTarget($schema, $filename) != $this->getSchemaTarget($schema, $filename, null, true)) {
//                    $response->addFile($this->renderFile(
//                        $template,
//                        $this->getSchemaTarget($schema, $filename, null, true),
//                        $this->getSchemaParameters($schema)
//                    ));
//                }
//            }
//        }
//
//        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function generateEnum(EnumDescriptor $enum)
    {
        return new GeneratorResponse();
    }

    /**
     * {@inheritdoc}
     */
    public function generateManifest(array $schemas)
    {
        return new GeneratorResponse();
    }

    /**
     * {@inheritdoc}
     */
    public function schemaToClassName(SchemaDescriptor $schema, $withMajor = false)
    {
        $className = StringUtils::toCamelFromSlug($schema->getId()->getMessage());
        if (!$withMajor) {
            return $className;
        }

        return "{$className}V{$schema->getId()->getVersion()->getMajor()}";
    }

    /**
     * {@inheritdoc}
     */
    public function schemaToFqClassName(SchemaDescriptor $schema, $withMajor = false)
    {
        $id = $schema->getId();
        $vendor = StringUtils::toCamelFromSlug($id->getVendor());
        $package = StringUtils::toCamelFromSlug(str_replace('.', '-', $id->getPackage()));
        $className = "{$vendor}{$package}{$this->schemaToClassName($schema)}";
        if (!$withMajor) {
            return $className;
        }

        return "{$className}V{$schema->getId()->getVersion()->getMajor()}";
    }

    /**
     * {@inheritdoc}
     */
    public function enumToClassName(EnumDescriptor $enum)
    {
        StringUtils::toCamelFromSlug($enum->getId()->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function schemaToNativePackage(SchemaDescriptor $schema)
    {
        $id = $schema->getId();
        return $this->getNativePackage($id->getVendor(), $id->getPackage());
    }

    /**
     * {@inheritdoc}
     */
    public function enumToNativePackage(EnumDescriptor $enum)
    {
        $id = $enum->getId();
        return $this->getNativePackage($id->getVendor(), $id->getPackage());
    }

    /**
     * {@inheritdoc}
     */
    public function schemaToNativeImportPath(SchemaDescriptor $schema, $withMajor = false)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function enumToNativeImportPath(EnumDescriptor $enum)
    {
    }

    /**
     * Generate a message (concrete class)
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateMessage(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Generate a message interface and add an output file
     * to the response.
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateMessageInterface(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Generates a mixin (schema fields "mixed" into messages).
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateMixin(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Generates a mixin interface.
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateMixinInterface(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Generates a mixin major (as in curie major) interface.
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateMixinMajorInterface(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Generates a trait (the functions/behavior provided by a mixin).
     *
     * @param SchemaDescriptor  $schema
     * @param GeneratorResponse $response
     */
    protected function generateTrait(SchemaDescriptor $schema, GeneratorResponse $response)
    {
    }

    /**
     * Adds and updates field php options.
     *
     * @param SchemaDescriptor $schema
     * @param FieldDescriptor  $field
     */
    protected function updateFieldOptions(SchemaDescriptor $schema, FieldDescriptor $field)
    {
    }

    /**
     * @param SchemaDescriptor $schema
     * @param string           $filename
     * @param string           $directory
     * @param bool             $isLatest
     *
     * @return string
     */
//    protected function getSchemaTarget(SchemaDescriptor $schema, $filename, $directory = null, $isLatest = false)
//    {
//        $filename = str_replace([
//            '{vendor}',
//            '{package}',
//            '{category}',
//            '{message}',
//            '{version}',
//            '{major}',
//        ], [
//            $schema->getId()->getVendor(),
//            $schema->getId()->getPackage(),
//            $schema->getId()->getCategory(),
//            $schema->getId()->getMessage(),
//            $schema->getId()->getVersion(),
//            $schema->getId()->getVersion()->getMajor(),
//        ], $filename);
//
//        if ($directory === null) {
//            $directory = sprintf('%s/%s/%s',
//                StringUtils::toCamelFromSlug($schema->getId()->getVendor()),
//                StringUtils::toCamelFromSlug($schema->getId()->getPackage()),
//                StringUtils::toCamelFromSlug($schema->getId()->getCategory())
//            );
//        }
//
//        $directory = trim($directory, '/') . '/';
//
//        return sprintf('%s/%s%s%s',
//            $this->compileOptions->getOutput(),
//            $directory,
//            $filename,
//            static::EXTENSION
//        );
//    }

    /**
     * @param string $template
     * @param string $target
     * @param array  $parameters
     *
     * @return OutputFile
     */
    protected function generateOutputFile($template, $target, array $parameters)
    {
        $template = sprintf('%s/%s', static::LANGUAGE, $template);
        $content = $this->render($template, $parameters);
        return new OutputFile($target, $content);
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return ?string
     */
    protected function getNativePackage($vendor, $package)
    {
        $packages = $this->compileOptions->getPackages();
        $vendorPackage = "{$vendor}:{$package}";

        if (isset($packages[$vendorPackage])) {
            return $packages[$vendorPackage];
        }

        if (isset($packages[$vendor])) {
            return $packages[$vendor];
        }

        return null;
    }

    /**
     * @param string $template
     * @param array  $parameters
     *
     * @return string
     */
    protected function render($template, array $parameters)
    {
        $twig = $this->getTwig();
        $parameters['compileOptions'] = $this->compileOptions;
        return $twig->render($template, $parameters);
    }

    /**
     * Get the twig environment that will render skeletons.
     *
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        if (null === $this->twig) {
            $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem(self::TEMPLATE_DIR), [
                'debug'            => true,
                'cache'            => false,
                'strict_variables' => true,
                'autoescape'       => false,
            ]);

            $this->twig->addExtension(new StringExtension());

            $class = sprintf(
                '\Gdbots\Pbjc\Generator\Twig\%sGeneratorExtension',
                StringUtils::toCamelFromSlug(static::LANGUAGE)
            );

            $this->twig->addExtension(new $class($this->compileOptions, $this));
        }

        return $this->twig;
    }
}

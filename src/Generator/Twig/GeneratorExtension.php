<?php

namespace Gdbots\Pbjc\Generator\Twig;

use Gdbots\Pbjc\CompileOptions;
use Gdbots\Pbjc\Generator\Generator;
use Gdbots\Pbjc\SchemaDescriptor;
use Gdbots\Pbjc\SchemaStore;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

abstract class GeneratorExtension extends AbstractExtension
{
    const LANGUAGE = 'unknown';

    /** @var CompileOptions */
    protected $compileOptions;

    /** @var Generator */
    protected $generator;

    /**
     * @param CompileOptions $compileOptions
     * @param Generator      $generator
     */
    public function __construct(CompileOptions $compileOptions, Generator $generator)
    {
        $this->compileOptions = $compileOptions;
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('has_other_major_rev', [$this, 'hasOtherMajorRev']),
            new TwigFunction('is_same_namespace', [$this, 'isSameNamespace']),
            new TwigFunction('get_all_versions', [$this, 'getAllVersions']),
            new TwigFunction('schema_to_class_name', [$this->generator, 'schemaToClassName']),
            new TwigFunction('schema_to_fq_class_name', [$this->generator, 'schemaToFqClassName']),
            new TwigFunction('enum_to_class_name', [$this->generator, 'enumToClassName']),
            new TwigFunction('schema_to_native_package', [$this->generator, 'schemaToNativePackage']),
            new TwigFunction('schema_to_native_class_path', [$this->generator, 'schemaToNativeClassPath']),
            new TwigFunction('enum_to_native_package', [$this->generator, 'enumToNativePackage']),
            new TwigFunction('schema_to_native_namespace', [$this->generator, 'schemaToNativeNamespace']),
            new TwigFunction('enum_to_native_namespace', [$this->generator, 'enumToNativeNamespace']),
        ];
    }

    /**
     * @param SchemaDescriptor $schema
     *
     * @return bool
     */
    public function hasOtherMajorRev(SchemaDescriptor $schema)
    {
        return SchemaStore::hasOtherSchemaMajorRev($schema->getId());
    }

    /**
     * @param SchemaDescriptor $a
     * @param SchemaDescriptor $b
     *
     * @return bool
     */
    public function isSameNamespace(SchemaDescriptor $a, SchemaDescriptor $b)
    {
        $ans = $this->generator->schemaToNativeNamespace($a);
        $bns = $this->generator->schemaToNativeNamespace($b);
        return $ans == $bns;
    }

    /**
     * @param SchemaDescriptor $schema
     *
     * @return SchemaDescriptor[]
     */
    public function getAllVersions(SchemaDescriptor $schema)
    {
        return SchemaStore::getAllSchemaVersions($schema->getId()) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return static::LANGUAGE . '_generator';
    }
}

<?php

namespace Gdbots\Pbjc\Command;

use Gdbots\Pbjc\Compiler;
use Gdbots\Pbjc\Generator\PhpGenerator;
use Gdbots\Pbjc\Generator\JsonGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Provides the console command to generate compiled files.
 */
class CompilerCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pbjc:compiler')
            ->addArgument(
                'language',
                InputArgument::REQUIRED,
                'The generated language (php, or json)'
            )
            ->addArgument(
                'namespace',
                InputArgument::REQUIRED,
                'The schema namespace (vendor:package)'
            )
            ->addArgument(
                'directory',
                InputArgument::REQUIRED,
                'The output directory files will be generate in'
            )
            ->setDescription('Generate compiled files')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command compiles and generates files for a select language.

To generate files you would need to specify the language, namespace and output directory:

  <info>pbjc php acme:blog src</info>

Note that currently we only support <comment>php</comment> or <comment>json</comment> languages.

EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $compile = new Compiler();
            $generator = $compile->run(
                $input->getArgument('language'),
                $input->getArgument('namespace'),
                $input->getArgument('directory')
            );

            $io = new SymfonyStyle($input, $output);

            if (count($generator->getFiles()) === 0) {
                throw new \Exception('No files were generated.');
            }

            $io->title('Generated files:');
            $io->listing(array_keys($generator->getFiles()));
            $io->success("\xf0\x9f\x91\x8d"); //thumbs-up-sign
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}

<?php

namespace Weirdan\PsalmPluginRdKafka;

use Generator;
use RegexIterator;
use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use RuntimeException;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Plugin implements PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null)
    {
        foreach ($this->getStubFiles() as $file) {
            $psalm->addStubFile($file);
        }
    }

    /** @return Generator<mixed, string> */
    private function getStubFiles(): Generator
    {
        if (file_exists(__DIR__ . '/../vendor')) {
            $stubDir = __DIR__ . '/../vendor/kwn/php-rdkafka-stubs/stubs';
        } else {
            $stubDir = __DIR__ . '/../../../kwn/php-rdkafka-stubs/stubs';
        }

        if (!file_exists($stubDir) || !is_dir($stubDir)) {
            throw new RuntimeException('Missing stub directory, run composer install');
        }

        yield from new RegexIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $stubDir,
                    RecursiveDirectoryIterator::CURRENT_AS_PATHNAME
                )
            ),
            '/.*php$/'
        );
    }
}

<?php

declare(strict_types=1);

namespace Jeidison\Factory7to8;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class UpgradeFactory
{
    /**
     * @var UpdateParam
     */
    private $param;

    /**
     * @var string
     */
    private $stubBase;

    public function __construct(?UpdateParam $param = null)
    {
        $this->param = $param ?? new UpdateParam;
        $this->stubBase = file_get_contents(__DIR__ . '/Factory.stub');
    }

    public function upgrade()
    {
        File::makeDirectory($this->param->getPathFactoryDest());
        $files = File::allFiles($this->param->getPathFactoryOrigin());
        foreach ($files as $file) {
            $contentOri = $file->getContents();
            $lines = explode("\n", $contentOri);
            list($classComplete, $className) = $this->retrieveClass($lines);
            if (!$classComplete || !$className)
                continue;

            $stub = $this->addModelNamespace($this->stubBase, $classComplete);
            $stub = $this->addModelAttribute($stub, $className);
            $stub = $this->addModelName($stub, $className);
            $stub = $this->addDefinition($lines, $stub);
            $this->addTrait($classComplete);

            $pathDestNewFile = str_replace('factories', 'Factories', $file->getRealPath());
            File::put($pathDestNewFile, $stub);
            echo "File factory converted successfully" . PHP_EOL;
        }

        File::moveDirectory($this->param->getPathFactoryOrigin(), $this->param->getPathFactoryOrigin() . '_old');
        File::moveDirectory($this->param->getPathFactoryDest(), str_replace('Factories', 'factories', $this->param->getPathFactoryDest()));
    }

    private function retrieveClass(array $lines)
    {
        foreach ($lines as $lineNumber => $line) {
            $startContent = '$factory->define(';
            $lengthStart = strlen($startContent);
            if (strpos($line, $startContent) === false) {
                continue;
            }

            $class = explode(',', substr($line, $lengthStart))[0];
            $classComplete = str_replace('::class', '', $class);
            if (!class_exists($classComplete)) {
                return $this->getClassComplete($classComplete);
            }

            $className = explode('\\', $classComplete);
            $className = end($className);
            return [$classComplete, $className];
        }
    }

    private function getClassComplete($classComplete)
    {
        foreach ($this->param->getDefaultNamespaces() as $namespace) {
            if (class_exists($namespace . $classComplete)) {
                return $namespace . $classComplete;
            }
        }
    }

    private function addDefinition(array $lines, string $stub)
    {
        $definition = "";
        $lineNumberStartDefinition = null;
        $lineNumberEndDefinition = null;
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, 'return [') !== false) {
                $lineNumberStartDefinition = $lineNumber;
            }

            if (strpos($line, '];') !== false) {
                $lineNumberEndDefinition = $lineNumber;
            }
        }

        foreach ($lines as $lineNumber => $line) {
            if ($lineNumber > $lineNumberStartDefinition && $lineNumber < $lineNumberEndDefinition) {
                $position = strpos($line, 'factory(');
                if ($position !== false) {
                    $strFactory = str_replace('factory(', '', substr($line, $position));
                    $classFactory = str_replace('::class),', '', $strFactory);
                    $line = str_replace(substr($line, $position), '\\' . $classFactory . '::factory(),', $line);
                } else {
                    $line = str_replace('$faker->', '$this->faker->', $line);
                }

                $line = str_replace("\t", '', $line);
                $line = trim(preg_replace('/\s+/', '', $line));
                $line = "\t\t\t" . $line;
                $definition .= $line . "\n";
            }
        }

        return str_replace('{{definition}}', $definition, $stub);
    }

    private function addTrait(string $classComplete)
    {
        if (!class_exists($classComplete) || $this->isFacade($classComplete)) {
            $classComplete = $this->getClassComplete($classComplete);
        }

        $rc = new ReflectionClass($classComplete);
        $pathClass = $rc->getFileName();
        $linesFile = file($pathClass);

        $lineTraits = null;
        $lineTraitNamespace = null;
        foreach ($linesFile as $lineNumber => &$line) {
            $position = strpos($line, 'class ');
            if ($position !== false) {
                $lineTraits = $lineNumber + 1;
                $lineTraitNamespace = $lineNumber - 1;
                continue;
            }

            if ($lineNumber === $lineTraits) {
                if ($line == "{\n") {
                    $lineTraits = $lineNumber + 1;
                    continue;
                }

                $lineTrait = str_replace(";\n", '', $line);
                $line = $lineTrait . ', ' . "HasFactory;\n";
                break;
            }
        }

        foreach ($linesFile as $lineNumber => &$line) {
            if ($lineNumber === $lineTraitNamespace) {
                $line = "use Illuminate\Database\Eloquent\Factories\HasFactory;\n\n";
                break;
            }
        }

        file_put_contents($pathClass, implode('', $linesFile));
    }

    private function isFacade($class)
    {
        $obj = new ReflectionClass($class);
        return $obj->isSubclassOf(Facade::class);
    }

    private function addModelNamespace(string $stub, string $modelNamespace)
    {
        return str_replace('{{modelNamespace}}', $modelNamespace, $stub);
    }

    private function addModelAttribute(string $stub, string $modelAttribute)
    {
        return str_replace('{{modelAttribute}}', '$model = ' . $modelAttribute, $stub);
    }

    private function addModelName(string $stub, string $modelName)
    {
        return str_replace('{{modelName}}', $modelName, $stub);
    }
}

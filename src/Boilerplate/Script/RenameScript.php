<?php

namespace Boilerplate\Script;

use \Exception;
use \InvalidArgumentException;

// Dependencies from PSR-7 (HTTP Messaging)
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Script\AbstractScript;

/**
 * Renames the current module's name
 *
 * The command-line action will alter the module's
 * file names and the contents of files to match
 * the provided name.
 */
class RenameScript extends AbstractScript
{
    /**
     * @var string $sourceName The original string to search and replace.
     */
    protected $sourceName = 'boilerplate';

    /**
     * @var string $projectName The user-provided name of the project.
     */
    protected $projectName;

    /**
     * Constructor — Register the action's arguments.
     */
    public function __construct()
    {
        $arguments = $this->defaultArguments();
        $this->setArguments($arguments);
    }

    /**
     * Retrieve the available default arguments of this action.
     *
     * @link http://climate.thephpleague.com/arguments/ For descriptions of the options for CLImate.
     *
     * @return array
     */
    public function defaultArguments()
    {
        $arguments = [
            'projectName' => [
                'longPrefix'   => 'name',
                'description'  => sprintf(
                    'Project (module) name. All occurences of "%s" in the files will be changed to this name.',
                    'Boilerplate'
                ),
                'defaultValue' => ''
            ]
        ];

        $arguments = array_merge(parent::defaultArguments(), $arguments);

        return $arguments;
    }

    /**
     * Set the current project name.
     *
     * @param string $projectName The name of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return RenameScript Chainable
     */
    public function setProjectName($projectName)
    {
        if (!is_string($projectName)) {
            throw new InvalidArgumentException(
                'Invalid project name. Must be a string.'
            );
        }

        if (!$projectName) {
            throw new InvalidArgumentException(
                'Invalid project name. Must contain at least one character.'
            );
        }

        if (!preg_match('/^[a-z]+$/', $projectName)) {
            throw new InvalidArgumentException(
                'Invalid project name. Only characters A-Z in lowercase are allowed.'
            );
        }

        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Retrieve the current project name.
     *
     * @return string
     */
    public function projectName()
    {
        return $this->projectName;
    }

    /**
     * Retrieve the response to the action.
     *
     * @return array
     */
    public function response()
    {
        return [
            'success' => $this->success()
        ];
    }

    /**
     * Interactively setup a Charcoal module.
     *
     * The action will ask the user a series of questions,
     * and then update the current module for them.
     *
     * It attempts to rename all occurrences of the "soure name"
     * with the provided Project name_.
     *
     * @see \League\CLImate\CLImate Used by `CliActionTrait`
     * @param RequestInterface  $request  PSR-7 request.
     * @param ResponseInterface $response PSR-7 response.
     * @return void
     */
    public function run(RequestInterface $request, ResponseInterface $response)
    {
        // Never Used
        unset($request, $response);

        $climate = $this->climate();

        $climate->underline()->out('Charcoal batch rename script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();
            return;
        }

        $climate->arguments->parse();
        $projectName = $climate->arguments->get('projectName');
        $verbose = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        if (!$projectName) {
            $input = $climate->input('What is the name of the project?');
            $projectName = strtolower($input->prompt());
        }

        try {
            $this->setProjectName($projectName);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        $climate->bold()->out(sprintf('Using "%s" as project name...', $projectName));
        $climate->out(sprintf('Using "%s" as namespace...', ucfirst($projectName)));

        // Replace file contents
        $this->replaceFileContent();

        // Rename files
        $this->renameFiles();

        $climate->green()->out("\n".'Success!');
    }

    /**
     * Replace "source name" in the contents of files.
     *
     * Renames all occurrences of "source name" with the provided Project name_
     * in the contents of all module files.
     *
     * @return void
     */
    protected function replaceFileContent()
    {
        $climate = $this->climate();
        $projectName = $this->projectName();
        $verbose = $this->verbose();

        $climate->out("\n".'Replacing file content...');
        $files = array_merge(
            $this->globRecursive('config/*'),
            $this->globRecursive('metadata/*'),
            $this->globRecursive('src/*'),
            $this->globRecursive('templates/*'),
            $this->globRecursive('tests/*'),
            $this->globRecursive('www/*'),
            glob('*.*')
        );
        foreach ($files as $filename) {
            if (is_dir($filename)) {
                continue;
            }
            $file = file_get_contents($filename);
            $numReplacement1 = 0;
            $numReplacement2 = 0;
            $content = preg_replace(
                '#'.$this->sourceName.'#',
                $projectName,
                $file,
                -1,
                $numReplacement1
            );
            $content = preg_replace(
                '#'.ucfirst($this->sourceNmae).'#',
                ucfirst($projectName),
                $content,
                -1,
                $numReplacement2
            );
            $numReplacements = ($numReplacement1+$numReplacement2);
            if ($numReplacements > 0) {
                // Save file content
                file_put_contents($filename, $content);
                $climate->dim()->out(
                    sprintf(
                        '%d occurence(s) of "%s" have been changed to "%s" in file "%s"',
                        $numReplacements,
                        $this->sourceName,
                        $projectName,
                        $filename
                    )
                );
            }
        }
    }

    /**
     * Replace "source name" in the names of files.
     *
     * Renames all occurrences of "source name" with the
     * provided _project name_ in all module file names.
     *
     * @return void
     */
    protected function renameFiles()
    {
        $climate = $this->climate();
        $projectName = $this->projectName();
        $verbose = $this->verbose();

        $climate->out("\n".'Renaming files and directories');
        $sourceFiles = $this->globRecursive('*'.$this->sourceName.'*');
        $sourceFiles = array_reverse($sourceFiles);

        foreach ($sourceFiles as $filename) {
            $targetName = preg_replace('#'.$this->sourceName.'#', $projectName, basename($filename));
            $targetName = dirname($filename).'/'.$targetName;

            if ($targetName != $filename) {
                rename($filename, $targetName);
                $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $targetName));
            }
        }

        $sourceFiles = $this->globRecursive('*'.ucfirst($this->sourceName).'*');
        $sourceFiles = array_reverse($sourceFiles);

        foreach ($sourceFiles as $filename) {
            $climate->inline('.');
            $targetName = preg_replace('/'.ucfirst($this->sourceName).'/', ucfirst($projectName), basename($filename));
            $targetName = dirname($filename).'/'.$targetName;

            if ($targetName != $filename) {
                rename($filename, $targetName);
                $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $targetName));
            }
        }
    }

    /**
     * Recursively find pathnames matching a pattern
     *
     * @see glob() for a description of the function and its parameters.
     *
     * @param string  $pattern The search pattern.
     * @param integer $flags   The glob flags.
     * @return array Returns an array containing the matched files/directories,
     *               an empty array if no file matched or FALSE on error.
     */
    private function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern).'/*', (GLOB_ONLYDIR|GLOB_NOSORT)) as $dir) {
            $files = array_merge($files, $this->globRecursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }
}

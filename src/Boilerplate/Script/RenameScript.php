<?php

namespace Boilerplate\Script;

use \Exception;
use \InvalidArgumentException;

// PSR-7 dependencies
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

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
     * @var string $ProjectName The user-provided name of the project.
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
                'description'  => 'Project (module) name. All occurences of "Boilerplate" in the files will be changed to this name.',
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
     * It attempts to rename all occurrences of "Boilerplate"
     * with the provided Project name_.
     *
     * @see \League\CLImate\CLImate Used by `CliActionTrait`
     * @param RequestInterface  $request  PSR-7 request.
     * @param ResponseInterface $response PSR-7 response.
     * @return void
     */
    public function run(RequestInterface $request, ResponseInterface $response)
    {
        $climate = $this->climate();

        $climate->underline()->out('Charcoal Boilerplate Module Setup');

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

        // Replace file contents
        $this->replaceFileContent();

        // Rename files
        $this->renameFiles();

        $climate->green()->out("\n".'Success!');
    }

    /**
     * Replace "Boilerplate" in the contents of files.
     *
     * Renames all occurrences of "Boilerplate" with the provided Project name_
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
            $content = preg_replace('/boilerplate/', $projectName, $file, -1, $numReplacement1);
            $content = preg_replace('/Boilerplate/', ucfirst($projectName), $content, -1, $numReplacement2);
            $numReplacements = ($numReplacement1+$numReplacement2);
            if ($numReplacements > 0) {
                //file_put_contents($filename, $content);
                if ($verbose) {
                    $climate->dim()->out(
                        sprintf(
                            '%d occurence(s) of "boilerplate" have been changed to "%s" in file "%s"',
                            $numReplacements,
                            $projectName,
                            $filename
                        )
                    );
                }
            }
        }
    }

    /**
     * Replace "Boilerplate" in the names of files.
     *
     * Renames all occurrences of "Boilerplate" with the
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
        $boilerplate_files = $this->globRecursive('*boilerplate*');
        $boilerplate_files = array_reverse($boilerplate_files);

        foreach ($boilerplate_files as $filename) {
            $targetName = preg_replace('/boilerplate/', $projectName, basename($filename));
            $targetName = dirname($filename).'/'.$targetName;

            if ($targetName != $filename) {
                //rename($filename, $targetName);
                if ($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $targetName));
                }
            }
        }

        $boilerplate_files = $this->globRecursive('*Boilerplate*');
        $boilerplate_files = array_reverse($boilerplate_files);

        foreach ($boilerplate_files as $filename) {
            $climate->inline('.');
            $targetName = preg_replace('/Boilerplate/', ucfirst($projectName), basename($filename));
            $targetName = dirname($filename).'/'.$targetName;

            if ($targetName != $filename) {
                //rename($filename, $targetName);
                if ($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $targetName));
                }
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

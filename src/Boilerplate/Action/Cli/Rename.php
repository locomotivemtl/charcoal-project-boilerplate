<?php

namespace Boilerplate\Action\Cli;

use \InvalidArgumentException as InvalidArgumentException;

use \Charcoal\Action\CliAction as CliAction;

if (!function_exists('glob_recursive')) {
    /**
    * Recursively find pathnames matching a pattern
    *
    * @see glob() for a description of the function and its parameters.
    *
    * @param string $pattern
    * @param int $flags
    * @return array Returns an array containing the matched files/directories,
    *               an empty array if no file matched or FALSE on error.
    */
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern).'/*', (GLOB_ONLYDIR|GLOB_NOSORT)) as $dir) {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }
}

/**
* Renames the current module's name
*
* The command-line action will alter the module's
* file names and the contents of files to match
* the provided name.
*/
class Rename extends CliAction
{
    /**
    * @var string $_project_name The user-provided name of the project.
    */
    protected $_project_name;

    /**
    * Constructor — Register the action's arguments.
    */
    public function __construct()
    {
        $arguments = $this->default_arguments();
        $this->set_arguments($arguments);
    }

    /**
    * Retrieve the available default arguments of this action.
    *
    * @link http://climate.thephpleague.com/arguments/ For descriptions of the options for CLImate.
    *
    * @return array
    */
    public function default_arguments()
    {
        $arguments = [
            'project_name' => [
                'longPrefix'   => 'name',
                'description'  => 'Project (module) name',
                'defaultValue' => ''
            ]
        ];

        $arguments = array_merge(parent::default_arguments(), $arguments);

        return $arguments;
    }

    /**
    * Set the current project name.
    *
    * @param string $project_name The name of the project
    * @return Rename Chainable
    * @throws InvalidArgumentException
    */
    public function set_project_name($project_name)
    {
        $__invalid = 'Invalid project name.';

        if (!is_string($project_name)) {
            throw new InvalidArgumentException("{$__invalid} Must be a string.");
        }

        if (!$project_name) {
            throw new InvalidArgumentException("{$__invalid} Must contain at least one character.");
        }

        if (!preg_match('/^[a-z]+$/', $project_name)) {
            throw new InvalidArgumentException("{$__invalid} Only characters A-Z in lowercase are allowed.");
        }

        $this->_project_name = $project_name;

        return $this;
    }

    /**
    * Retrieve the current project name.
    *
    * @return string
    */
    public function project_name()
    {
        return $this->_project_name;
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
    * with the provided _project name_.
    *
    * @see \League\CLImate\CLImate Used by `CliActionTrait`
    */
    public function run()
    {
        $climate = $this->climate();

        $climate->underline()->out('Charcoal Boilerplate Module Setup');

        if ($climate->arguments->defined('help')) {
            $climate->usage();
            die();
        }

        $climate->arguments->parse();
        $project_name = $climate->arguments->get('project_name');
        $verbose = (bool)$climate->arguments->get('quiet');
        $this->set_verbose($verbose);

        if (!$project_name) {
            $input = $climate->input('What is the name of the project?');
            $project_name = strtolower($input->prompt());
        }

        try {
            $this->set_project_name($project_name);
        } catch (\Exception $e) {
            $climate->error($e->getMessage());
        }

        $climate->bold()->out(sprintf('Using "%s" as project name...', $project_name));

        // Replace file contents
        $this->replace_file_content();

        // Rename files
        $this->rename_files();

        $climate->green()->out("\n".'Success!');
    }

    /**
    * Replace "Boilerplate" in the contents of files.
    *
    * Renames all occurrences of "Boilerplate" with the provided _project name_
    * in the contents of all module files.
    */
    protected function replace_file_content()
    {
        $climate = $this->climate();
        $project_name = $this->project_name();
        $verbose = $this->verbose();

        $climate->out("\n".'Replacing file content...');
        $files = array_merge(
            glob_recursive('config/*'),
            glob_recursive('metadata/*'),
            glob_recursive('src/*'),
            glob_recursive('templates/*'),
            glob_recursive('tests/*'),
            glob_recursive('www/*'),
            glob('*.*')
        );
        foreach ($files as $filename) {
            if (is_dir($filename)) {
                continue;
            }
            $file = file_get_contents($filename);
            $num_replacement1 = 0;
            $num_replacement2 = 0;
            $content = preg_replace("/boilerplate/", $project_name, $file, -1, $num_replacement1);
            $content = preg_replace("/Boilerplate/", ucfirst($project_name), $content, -1, $num_replacement2);
            $num_replacements = ($num_replacement1+$num_replacement2);
            if ($num_replacements > 0) {
                //file_put_contents($filename, $content);
                if ($verbose) {
                    $climate->dim()->out(
                        sprintf(
                            '%d occurence(s) of "boilerplate" have been changed to "%s" in file "%s"',
                            $num_replacements,
                            $project_name,
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
    */
    protected function rename_files()
    {
        $climate = $this->climate();
        $project_name = $this->project_name();
        $verbose = $this->verbose();

        $climate->out("\n".'Renaming files and directories');
        $boilerplate_files = glob_recursive("*boilerplate*");
        $boilerplate_files = array_reverse($boilerplate_files);

        foreach ($boilerplate_files as $filename) {
            $target_name = preg_replace("/boilerplate/", $project_name, basename($filename));
            $target_name = dirname($filename).'/'.$target_name;

            if ($target_name != $filename) {
                //rename($filename, $target_name);
                if ($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $target_name));
                }
            }

        }

        $boilerplate_files = glob_recursive("*Boilerplate*");
        $boilerplate_files = array_reverse($boilerplate_files);

        foreach ($boilerplate_files as $filename) {
            $climate->inline('.');
            $target_name = preg_replace("/Boilerplate/", ucfirst($project_name), basename($filename));
            $target_name = dirname($filename).'/'.$target_name;

            if ($target_name != $filename) {
                //rename($filename, $target_name);
                if ($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $target_name));
                }
            }
        }
    }
}

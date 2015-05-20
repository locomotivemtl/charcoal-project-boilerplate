<?php

namespace Boilerplate\Action\Cli;

use \InvalidArgumentException as InvalidArgumentException;

use \Charcoal\Action\CliAction as CliAction;

class Rename extends CliAction
{

    protected $_project_name;

    public function __construct()
    {
        $arguments = $this->default_arguments();
        $this->set_arguments($arguments);

    }

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

    public function set_project_name($project_name)
    {
        if(!is_string($project_name)) {
            throw new InvalidArgumentException('Invalid project name');
        }
        if(!$project_name) {
            throw new InvalidArgumentException('Invalid project name');
        }
        if(!preg_match('/^[a-z]+$/', $project_name)) {
            throw new InvalidArgumentException('Invalid project name (must be lowercase)');
        }
        $this->_project_name = $project_name;
        return $this;
    }

    public function project_name()
    {
        return $this->_project_name;
    }


    public function response()
    {
        return [
            'success'=>$this->success()
        ];
    }

    public function run()
    {
        $climate = $this->climate();

        $climate->underline()->out('Charcoal Boilerplate Module Setup');

        if($climate->arguments->defined('help')) {
            $climate->usage();
            die();
        }
        
        $climate->arguments->parse();
        $project_name = $climate->arguments->get('project_name');
        $verbose = !!$climate->arguments->get('quiet');
        $verbose = true;

        if(!$project_name) {
            $input = $climate->input('What is the name of the project?');
            $project_name = strtolower($input->prompt());
        }
        try {
            $this->set_project_name($project_name);
        }
        catch(\Exception $e) {
            $climate->error($e->getMessage());
        }

        if(!function_exists('glob_recursive')) {
            function glob_recursive($pattern, $flags = 0)
            {
                $files = glob($pattern, $flags);
                foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
                    $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
                }
                return $files;
            }
        }

        $climate->bold()->out(sprintf('Using "%s" as project name...', $project_name));
        
        // Replace file contents
        $this->replace_file_content();

        // Rename files
        $this->rename_files();

        $climate->green()->out("\n".'Success!');
    }

    protected function replace_file_content()
    {
        $climate = $this->climate();
        $project_name = $this->project_name();

        $climate->out("\n".'Replacing file content...');
        foreach(glob_recursive("www/*") as $filename) {
            if(!is_dir($filename)) {
                $file = file_get_contents($filename);
                $num_replacement1 = 0;
                $num_replacement2 = 0;
                $content = preg_replace("/boilerplate/", $project_name, $file, -1, $num_replacement1);
                $content = preg_replace("/Boilerplate/", ucfirst($project_name), $content, -1, $num_replacement2);
                $num_replacements = ($num_replacement1+$num_replacement2);
                if($num_replacements > 0) {
                    //file_put_contents($filename, $content);
                    if($verbose) {
                        $climate->dim()->out(sprintf('%d occurence(s) of "boilerplate" has been changed to "%s" in file "%s"', $num_replacements, $project_name, $filename));
                    }
                }
            }
        }
    }

    protected function rename_files()
    {
        $climate->out("\n".'Renaming files and directories');
        $boilerplate_files = glob_recursive("www/*boilerplate*");
        $boilerplate_files = array_reverse($boilerplate_files);
        foreach($boilerplate_files as $filename) {
            $target_name = preg_replace("/boilerplate/", $project_name, basename($filename));
            $target_name = dirname($filename).'/'.$target_name;
            if($target_name != $filename) {
                //rename($filename, $target_name);
                if($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $target_name));
                }
            }

        }

        $boilerplate_files = glob_recursive("www/*Boilerplate*");
        $boilerplate_files = array_reverse($boilerplate_files);
        foreach($boilerplate_files as $filename) {
            $climate->inline('.');
            $target_name = preg_replace("/Boilerplate/", ucfirst($project_name), basename($filename));
            $target_name = dirname($filename).'/'.$target_name;
            if($target_name != $filename) {
                //rename($filename, $target_name);
                if($verbose) {
                    $climate->dim()->out(sprintf('%s has been renamed to %s', $filename, $target_name));
                }
            }
        }
    }
}
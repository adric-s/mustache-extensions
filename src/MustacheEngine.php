<?php
namespace Adric\Mustache;

use \Mustache_Engine;
use \Mustache_Loader_FilesystemLoader;
use \Mustache_Exception_InvalidArgumentException;
use \Mustache_Exception_UnknownTemplateException;

class MustacheEngine extends Mustache_Engine {

    const DEFAULT_EXTENSION = 'mustache';

    protected $templateDirectory;
    protected $templateExtension;

    public function __construct(array $options = array()) {
        if (isset($options['template_directory'])) {
            $this->templateDirectory = $options['template_directory'];
        } else {
            throw new Mustache_Exception_InvalidArgumentException('template_directory option must be specified');
        }
        if (isset($options['template_extension'])) {
            $this->templateExtension = $options['template_extension'];
        } else {
            $this->templateExtension = static::DEFAULT_EXTENSION;
        }
        $options['partials_loader'] = new MustacheVariablePartialLoader(
            $this->templateDirectory,
            array(
                'extension' => $this->templateExtension
            )
        );
    }

    public function renderFromFile($template, $vars = array()) {
        $templateFile = $this->templateDirectory . DIRECTORY_SEPARATOR . $template . '.' . $this->templateExtension;
        if (!is_file($templateFile)) {
            throw new Mustache_Exception_UnknownTemplateException("Template file $templateFile does not exist");
        }
        $template = file_get_contents($templateFile);
        return $this->render($template, $vars);
    }

    public function render($template, $vars = array()) {
        $partialsLoader = $this->getPartialsLoader();
        $partialsLoader->setVars($vars);
        return parent::render($template, $vars);
    }
}


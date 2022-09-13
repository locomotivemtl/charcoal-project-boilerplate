<?php

namespace App\Template;

use Charcoal\Cms\AbstractWebTemplate;

/**
 * Base Template Controller
 */
abstract class AbstractTemplate extends AbstractWebTemplate
{
    /**
     * Static assets versionning.
     *
     * @var string
     */
    public const ASSETS_VERSION = '1.0.0';



    // Site Head/Metatags
    // ============================================================

    /**
     * Retrieve the site name.
     *
     * @return string|null
     */
    public function siteName()
    {
        return $this->appConfig('project_name');
    }



    // APIs
    // ============================================================

    /**
     * @return string
     */
    public function google()
    {
        return $this->appConfig('apis.google');
    }

    /**
     * @return string
     */
    public function typekit()
    {
        return $this->appConfig('apis.typekit');
    }



    // Presentation & Templating
    // =========================================================================

    /**
     * Retrieve the <html> element attribute structure.
     *
     * @return array
     */
    protected function htmlAttrStructure()
    {
        $classes = [ 'has-no-js' ];

        return [
            'class'         => $classes,
            'lang'          => $this->currentLanguage(),
            'data-template' => $this->templateName(),
            'data-debug'    => $this->debug() ? 'true' : false,
        ];
    }

    /**
     * Generate a string containing HTML attributes for the <html> element.
     *
     * @return string
     */
    public function htmlAttr()
    {
        return html_build_attributes($this->htmlAttrStructure());
    }

    /**
     * Retrieve the assets version for cache busting.
     *
     * @return string
     */
    public function assetsVersion()
    {
        return self::ASSETS_VERSION;
    }

    /**
     * @return string
     */
    public function copyright()
    {
        return sprintf('© %s %s', $this->copyrightYear(), $this->copyrightName());
    }

    /**
     * @return string
     */
    public function copyrightName()
    {
        return $this->appConfig('project_name');
    }

    /**
     * Retrieve current year (for copyright info).
     *
     * @return string
     */
    public function copyrightYear()
    {
        return date('Y');
    }



    // Front-end helpers
    // ============================================================

    /**
     * Loop X number of times.
     *
     * @return array
     */
    public function forLoop()
    {
        $i = 0;
        $max = 50;
        $out = [];
        for (; $i < $max; $i++) {
            $k = 1;
            $mini = [];
            for (; $k <= $i; $k++) {
                $mini[] = $k;
            }

            $out[(string)$i] = $mini;
        }

        return $out;
    }

    /**
     * Retrieve the critical stylesheet to inject in the markup.
     *
     * @return string
     */
    public function criticalCss()
    {
        $filePath = $this->appConfig()->publicPath() . 'assets/styles/critical.css';
        if (file_exists($filePath)) {
            ob_start();
            echo file_get_contents($filePath);
            return ob_get_clean();
        }

        return '';
    }
}

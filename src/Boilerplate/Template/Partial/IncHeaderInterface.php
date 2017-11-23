<?php

namespace Boilerplate\Template\Partial;

/**
 *
 */
interface IncHeaderInterface
{
    /**
     * @return string
     */
    public function lang();

    /**
     * @return array
     */
    public function meta();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function pageTitle();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaPrefix();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaTitle();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaDescription();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaTags();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function opengraphTags();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function extraHeaderContent();

    /**
     * @return string
     */
    public function googleAnalytics();

    /**
     * @return string
     */
    public function typekit();
}

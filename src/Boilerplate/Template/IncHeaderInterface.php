<?php

namespace Boilerplate\Template;

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
     * @return string|TranslationString
     */
    public function pageTitle();

    /**
     * @return string|TranslationString
     */
    public function metaPrefix();

    /**
     * @return string|TranslationString
     */
    public function metaTitle();

    /**
     * @return string|TranslationString
     */
    public function metaDescription();

    /**
     * @return string|TranslationString
     */
    public function metaTags();

    /**
     * @return string|TranslationString
     */
    public function opengraphTags();

    /**
     * @return string|TranslationString
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

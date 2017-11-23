<?php

namespace Boilerplate\Template\Partial;

/**
 * Header include. Provide defaults (stubs) to fulfill the interface.
 */
trait IncHeaderTrait
{
    /**
     * @return string
     */
    abstract public function lang();

    /**
     * @return array
     */
    abstract public function meta();

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function pageTitle()
    {
        return 'Charcoal Project Boilerplate';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaPrefix()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function metaSuffix()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function defaultMetaTitle()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function defaultMetaDescription()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function defaultMetaTags()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    /*
    public function opengraphTags()
    {
        return '';
    }
    */

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function defaultMetaImage()
    {
        return '';
    }

    /**
     * @return string|\Charcoal\Translator\Translation
     */
    public function extraHeaderContent()
    {
        return '';
    }

    /**
     * @return string
     */
    public function googleAnalytics()
    {
        $analyticsCfg = $this->appConfig->get('apis.google.analytics');
        if (isset($analyticsCfg['tracking_id'])) {
            return $analyticsCfg['tracking_id'];
        }
        return '';
    }

    /**
     * @return string
     */
    public function typekit()
    {
        $typekitCfg = $this->appConfig->get('apis.typekit');
        if (isset($typekitCfg['kit_id'])) {
            return $typekitCfg['kit_id'];
        }
        return '';
    }
}

<?php

namespace Boilerplate\Template;

/**
 * Interface BrowserParserAwareInterface
 *
 * Browser detection helper with BrowserParser
 */
interface BrowserParserAwareInterface
{
    /**
     * @return \WhichBrowser\Parser Set from dependencies container.
     */
    public function browserParser();

    /**
     * Use BrowserParser to determine if is iOS.
     *
     * @return boolean
     */
    public function isIos();

    /**
     * Use BrowserParser to determine if is IE10
     *
     * @return boolean
     */
    public function isIe10();

    /**
     * Use BrowserParser to determine if is Internet Explorer (or Edge)
     *
     * @return boolean
     */
    public function isIe();

    /**
     * Use BrowserParser to determine if is Trident
     *
     * @return boolean
     */
    public function isTrident();

    /**
     * Use BrowserParser to determine if is Edge
     *
     * @return boolean
     */
    public function isEdge();

    /**
     * Use BrowserParser to determine if is Firefox
     *
     * @return boolean
     */
    public function isFirefox();
}

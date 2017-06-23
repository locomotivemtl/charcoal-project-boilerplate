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
     * @return Parser Set from dependencies container.
     */
    public function browserParser();

    /**
     * Use BrowserParser to determine if is iOS.
     *
     * @return boolean
     */
    public function isIos();

    /**
     * Use BrowserParser to determine if is IE9 (or less)
     *
     * @return boolean
     */
    public function isIe9();

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
}

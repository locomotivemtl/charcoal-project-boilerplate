<?php

namespace Boilerplate\Template;

use \WhichBrowser\Parser;

/**
 * Implementation of the BrowserParserAwareInterface
 *
 * Encapsulates all browser-parsing related functions in a single trait.
 */
trait BrowserParserAwareTrait
{
    /**
     * @var Parser $browserParser
     */
    private $browserParser;

    /**
     * @param Parser $parser The browser parser, from dependencies container.
     * @return void
     */
    protected function setBrowserParser(Parser $parser)
    {
        $this->browserParser = $parser;
    }

    /**
     * @return Parser Set from dependencies container.
     */
    public function browserParser()
    {
        return $this->browserParser;
    }

    /**
     * Use BrowserParser to determine if is iOS.
     *
     * @return boolean
     */
    public function isIos()
    {
        return $this->browserParser()->isOs('iOS');
    }

    /**
     * Use BrowserParser to determine if is IE9 (or less)
     *
     * @return boolean
     */
    public function isIe9()
    {
        return $this->browserParser()->isBrowser('Internet Explorer', '<', '10');
    }

    /**
     * Use BrowserParser to determine if is IE10
     *
     * @return boolean
     */
    public function isIe10()
    {
        return $this->browserParser()->isBrowser('Internet Explorer', '=', '10');
    }

    /**
     * Use BrowserParser to determine if is Internet Explorer (or Edge)
     *
     * @return boolean
     */
    public function isIe()
    {
        return  $this->browserParser()->isBrowser('Internet Explorer') ||
            $this->browserParser()->isBrowser('Edge');
    }
}

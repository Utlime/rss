<?php namespace Utlime\RSS;

/**
 * Interface CDATAInterface
 * @package Utlime\RSS
 */
interface CDATAInterface
{
    /**
     * @param string $section
     * @param bool   $val
     * @return $this
     */
    public function setCDATA($section, $val = true);

    /**
     * @param string $section
     * @return bool|null
     */
    public function getCDATA($section);
}
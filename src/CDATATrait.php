<?php namespace Utlime\RSS;

/**
 * Class CDATATrait
 * @package Utlime\RSS
 */
trait CDATATrait
{
    /** @var array|bool[] */
    protected $CDATA = [];

    /**
     * @param string $section
     * @param bool   $val
     * @return $this
     */
    public function setCDATA($section, $val = true)
    {
        $this->CDATA[$section] = $val;

        return $this;
    }

    /**
     * @param string $section
     * @return bool|null
     */
    public function getCDATA($section)
    {
        return array_key_exists($section, $this->CDATA) ? $this->CDATA[$section] : null;
    }
}
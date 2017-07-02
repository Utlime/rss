<?php namespace Utlime\RSS;

/**
 * Class RSS
 * @package Utlime\RSS
 */
class RSS
{
    /** @var \Iterator|Channel[] */
    protected $channels = [];

    /**
     * @return \Iterator|Channel[]
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param \Iterator|Channel[] $channels
     * @return RSS
     */
    public function setChannels(\Iterator $channels = null)
    {
        $this->channels = $channels;

        return $this;
    }
}
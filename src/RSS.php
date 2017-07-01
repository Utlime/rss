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
     * Feed constructor.
     * @param \Iterator|Channel[] $channels
     */
    public function __construct(\Iterator $channels)
    {
        $this->channels = $channels;
    }

    /**
     * @return \Iterator|Channel[]
     */
    public function getChannels()
    {
        return $this->channels;
    }
}
<?php namespace Utlime\RSS;

/**
 * Class Writer
 * @package Utlime\RSS
 */
class Writer
{
    const CDATA_CHANNEL_TITLE       = 'channel:title';
    const CDATA_CHANNEL_DESCRIPTION = 'channel:description';
    const CDATA_ITEM_TITLE          = 'item:title';
    const CDATA_ITEM_DESCRIPTION    = 'item:description';

    /** @var callable */
    protected $output;

    /** @var array|bool[] */
    protected $CDATA = [];

    /**
     * Writer constructor.
     * @param callable $output
     */
    public function __construct(callable $output = null)
    {
        $this->output = $output ?: [$this, 'defaultOutput'];
    }

    /**
     * @param string $section
     * @param bool   $val
     * @return Writer
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
        return isset($this->CDATA[$section]) ? $this->CDATA[$section] : null;
    }

    /**
     * @param RSS $rss
     */
    public function write(RSS $rss)
    {
        call_user_func($this->output, '<?xml version="1.0" encoding="UTF-8"?>');

        $this->writeRSS($rss);
    }

    /**
     * @param RSS $rss
     */
    public function writeRSS(RSS $rss)
    {
        call_user_func($this->output, '<rss version="2.0">');

        if ($rss->getChannels() instanceof \Iterator) {
            foreach ($rss->getChannels() as $channel) {
                $this->writeChannel($channel);
            }
        }

        call_user_func($this->output, '</rss>');
    }

    /**
     * @param Channel $channel
     */
    public function writeChannel(Channel $channel)
    {
        call_user_func($this->output, '<channel>');

        call_user_func($this->output, '<title>');

        if ($this->getCDATA(self::CDATA_CHANNEL_TITLE)) {
            call_user_func($this->output, '<![CDATA[');
        }

        call_user_func($this->output, $channel->getTitle());

        if ($this->getCDATA(self::CDATA_CHANNEL_TITLE)) {
            call_user_func($this->output, ']]>');
        }

        call_user_func($this->output, '</title>');

        call_user_func($this->output, '<link>');
        call_user_func($this->output, $channel->getLink());
        call_user_func($this->output, '</link>');

        call_user_func($this->output, '<description>');

        if ($this->getCDATA(self::CDATA_CHANNEL_DESCRIPTION)) {
            call_user_func($this->output, '<![CDATA[');
        }

        call_user_func($this->output, $channel->getDescription());

        if ($this->getCDATA(self::CDATA_CHANNEL_DESCRIPTION)) {
            call_user_func($this->output, ']]>');
        }

        call_user_func($this->output, '</description>');

        if (!is_null($channel->getLanguage())) {
            call_user_func($this->output, '<language>');
            call_user_func($this->output, $channel->getLanguage());
            call_user_func($this->output, '</language>');
        }

        if (!is_null($channel->getCopyright())) {
            call_user_func($this->output, '<copyright>');
            call_user_func($this->output, $channel->getCopyright());
            call_user_func($this->output, '</copyright>');
        }

        if ($channel->getPubDate() instanceof \DateTimeInterface) {
            call_user_func($this->output, '<pubDate>');
            call_user_func($this->output, $channel->getPubDate()->format(DATE_RSS));
            call_user_func($this->output, '</pubDate>');
        }

        if ($channel->getLastBuildDate() instanceof \DateTimeInterface) {
            call_user_func($this->output, '<lastBuildDate>');
            call_user_func($this->output, $channel->getLastBuildDate()->format(DATE_RSS));
            call_user_func($this->output, '</lastBuildDate>');
        }

        if (!is_null($channel->getCategory())) {
            call_user_func($this->output, '<category>');
            call_user_func($this->output, $channel->getCategory());
            call_user_func($this->output, '</category>');
        }

        if (!is_null($channel->getTTL())) {
            call_user_func($this->output, '<ttl>');
            call_user_func($this->output, $channel->getTTL());
            call_user_func($this->output, '</ttl>');
        }

        if ($channel->getItems() instanceof \Iterator) {
            foreach ($channel->getItems() as $item) {
                $this->writeItem($item);
            }
        }

        call_user_func($this->output, '</channel>');
    }

    /**
     * @param Item $item
     */
    public function writeItem(Item $item)
    {
        call_user_func($this->output, '<item>');

        if (!is_null($item->getTitle())) {
            call_user_func($this->output, '<title>');

            if ($this->getCDATA(self::CDATA_ITEM_TITLE)) {
                call_user_func($this->output, '<![CDATA[');
            }

            call_user_func($this->output, $item->getTitle());

            if ($this->getCDATA(self::CDATA_ITEM_TITLE)) {
                call_user_func($this->output, ']]>');
            }

            call_user_func($this->output, '</title>');
        }

        if (!is_null($item->getLink())) {
            call_user_func($this->output, '<link>');
            call_user_func($this->output, $item->getLink());
            call_user_func($this->output, '</link>');
        }

        if (!is_null($item->getDescription())) {
            call_user_func($this->output, '<description>');

            if ($this->getCDATA(self::CDATA_ITEM_DESCRIPTION)) {
                call_user_func($this->output, '<![CDATA[');
            }

            call_user_func($this->output, $item->getDescription());

            if ($this->getCDATA(self::CDATA_ITEM_DESCRIPTION)) {
                call_user_func($this->output, ']]>');
            }

            call_user_func($this->output, '</description>');
        }

        if (!is_null($item->getCategory())) {
            call_user_func($this->output, '<category>');
            call_user_func($this->output, $item->getCategory());
            call_user_func($this->output, '</category>');
        }

        if (!is_null($item->getGUID())) {
            call_user_func($this->output, '<guid>');
            call_user_func($this->output, $item->getGUID());
            call_user_func($this->output, '</guid>');
        }

        if (!is_null($item->getPubDate())) {
            call_user_func($this->output, '<pubDate>');
            call_user_func($this->output, $item->getPubDate()->format(DATE_RSS));
            call_user_func($this->output, '</pubDate>');
        }

        if (!is_null($item->getEnclosure())) {
            call_user_func(
                $this->output,
                strtr(
                    '<enclosure url="{u}" type="{t}" length="{l}" />',
                    [
                        '{u}' => $item->getEnclosure()['url'],
                        '{t}' => $item->getEnclosure()['type'],
                        '{l}' => $item->getEnclosure()['length'],
                    ]
                )
            );
        }

        call_user_func($this->output, '</item>');
    }

    /**
     * @param string $string
     */
    protected function defaultOutput($string)
    {
        echo $string;
    }
}
<?php namespace Utlime\RSS;

/**
 * Class Writer
 * @package Utlime\RSS
 */
class Writer
{
    /** @var callable */
    protected $output;

    /**
     * Writer constructor.
     * @param callable $output
     */
    public function __construct(callable $output = null)
    {
        $this->output = $output ?: [$this, 'defaultOutput'];
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
        call_user_func($this->output, $channel->getTitle());
        call_user_func($this->output, '</title>');

        call_user_func($this->output, '<link>');
        call_user_func($this->output, $channel->getLink());
        call_user_func($this->output, '</link>');

        call_user_func($this->output, '<description>');
        call_user_func($this->output, $channel->getDescription());
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
            call_user_func($this->output, $item->getTitle());
            call_user_func($this->output, '</title>');
        }

        if (!is_null($item->getLink())) {
            call_user_func($this->output, '<link>');
            call_user_func($this->output, $item->getLink());
            call_user_func($this->output, '</link>');
        }

        if (!is_null($item->getDescription())) {
            call_user_func($this->output, '<description>');
            call_user_func($this->output, $item->getDescription());
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
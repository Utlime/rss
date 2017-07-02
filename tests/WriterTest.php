<?php namespace Utlime\RSS;

use PHPUnit\Framework\TestCase;

class WriterTest extends TestCase
{
    /**
     * @covers Writer::writeItem
     * @return Item
     */
    public function testItem()
    {
        $template = '<item></item>';
        $output   = '';

        $item = new Item();

        (new Writer(function ($string) use (&$output) {$output .= $string;}))->writeItem($item);

        $this->assertEquals($template, $output);

        return $item;
    }

    /**
     * @covers Writer::writeChannel
     * @return Channel
     */
    public function testChannel()
    {
        $output   = '';
        $template =
            '<channel>'
                . '<title>title</title>'
                . '<link>link</link>'
                . '<description>description</description>'
            . '</channel>';

        $channel = new Channel('title', 'link', 'description');

        (new Writer(function ($string) use (&$output) {$output .= $string;}))->writeChannel($channel);

        $this->assertEquals($template, $output);

        return $channel;
    }

    /**
     * @covers Writer::writeRSS
     * @return RSS
     */
    public function testRSS()
    {
        $output   = '';
        $template = '<rss version="2.0"></rss>';

        $rss = new RSS();

        (new Writer(function ($string) use (&$output) {$output .= $string;}))->writeRSS($rss);

        $this->assertEquals($template, $output);

        return $rss;
    }

    /**
     * @covers Writer::write
     * @depends testRSS
     * @depends testChannel
     * @depends testItem
     * @param RSS     $rss
     * @param Channel $channel
     * @param Item    $item
     */
    public function testFeed(RSS $rss, Channel $channel, Item $item)
    {
        $output =
            '<?xml version="1.0" encoding="UTF-8"?>'
            . '<rss version="2.0">'
                . '<channel>'
                    . '<title>title</title>'
                    . '<link>link</link>'
                    . '<description>description</description>'
                    . '<item></item>'
                . '</channel>'
            . '</rss>';

        $rss->setChannels(
            new \ArrayIterator([
                $channel->setItems(
                    new \ArrayIterator([$item])
                )
            ])
        );

        (new Writer(function ($string) use (&$output) {$output .= $string;}))->write($rss);
    }
}
<?php namespace Utlime\RSS;

use PHPUnit\Framework\TestCase;

/**
 * Class WriterTest
 * @package Utlime\RSS
 */
class WriterTest extends TestCase
{
    /**
     * @covers       Writer::writeItem
     * @dataProvider providerItem
     * @param Item   $item
     * @param string $expectedFile
     * @return Item
     */
    public function testWriteItem(Item $item, $expectedFile)
    {
        $xmlAsString = '';

        (new Writer(function ($string) use (&$xmlAsString) {
            $xmlAsString .= $string;
        }))->writeItem($item);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $xmlAsString);

        return $item;
    }

    /**
     * @return \Generator
     */
    public function providerItem()
    {
        yield [new Item(),  __DIR__ . '/expected/item.minimal.xml'];
    }

    /**
     * @covers       Writer::writeChannel
     * @dataProvider providerChannel
     * @param Channel $channel
     * @param string  $expectedFile
     * @return Channel
     */
    public function testWriteChannel(Channel $channel, $expectedFile)
    {
        $xmlAsString = '';

        (new Writer(function ($string) use (&$xmlAsString) {
            $xmlAsString .= $string;
        }))->writeChannel($channel);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $xmlAsString);

        return $channel;
    }

    /**
     * @return \Generator
     */
    public function providerChannel()
    {
        yield [new Channel('title', 'link', 'description'), __DIR__ . '/expected/channel.minimal.xml'];
    }

    /**
     * @covers       Writer::writeRSS
     * @dataProvider providerRSS
     * @param RSS    $rss
     * @param string $expectedFile
     * @return RSS
     */
    public function testWriteRSS(RSS $rss, $expectedFile)
    {
        $xmlAsString = '';

        (new Writer(function ($string) use (&$xmlAsString) {
            $xmlAsString .= $string;
        }))->writeRSS($rss);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $xmlAsString);

        return $rss;
    }

    /**
     * @return \Generator
     */
    public function providerRSS()
    {
        yield [new RSS(), __DIR__ . '/expected/rss.minimal.xml'];
    }

    /**
     * @covers       Writer::write
     * @dataProvider providerFeed
     * @param RSS    $rss
     * @param string $expectedFile
     * @return RSS
     */
    public function testWriteFeed(RSS $rss, $expectedFile)
    {
        $xmlAsString = '';

        (new Writer(function ($string) use (&$xmlAsString) {
            $xmlAsString .= $string;
        }))->write($rss);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $xmlAsString);

        return $rss;
    }

    /**
     * @return \Generator
     */
    public function providerFeed()
    {
        $rss     = new RSS();
        $channel = new Channel('title', 'link', 'description');
        $item    = new Item();

        $rss->setChannels(
            new \ArrayIterator([
                $channel->setItems(
                    new \ArrayIterator([$item])
                ),
            ])
        );

        yield [$rss, __DIR__ . '/expected/feed.minimal.xml'];

        $channel->setCDATA(Channel::CDATA_CHANNEL_TITLE);

        yield [$rss, __DIR__ . '/expected/feed.cdata.xml'];
    }
}
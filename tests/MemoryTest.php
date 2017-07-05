<?php namespace Utlime\RSS;

use PHPUnit\Framework\TestCase;

/**
 * Class MemoryTest
 * @package Utlime\RSS
 */
class MemoryTest extends TestCase
{
    /** @var null|int */
    protected static $memory_usage = null;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $rss   = self::getRSS(1, 1, false);
        $write = self::getWriter();
        $write->write($rss);
    }

    /**
     * @return void
     */
    public static function tearDownAfterClass()
    {
        self::$memory_usage = null;
    }

    /**
     * @return array|array[]
     */
    public function providerSize()
    {
        return [
            'Lazy size 10x10'     => [10, 10, true],
            'Lazy size 100x10'    => [100, 10, true],
            'Lazy size 100x100'   => [100, 100, true],
            'Lazy size 1000x100'  => [1000, 100, true],
            'Eager size 10x10'    => [10, 10, false],
            'Eager size 100x10'   => [100, 10, false],
            'Eager size 100x100'  => [100, 100, false],
            'Eager size 1000x100' => [1000, 100, false],
        ];
    }

    /**
     * @dataProvider providerSize
     * @param int  $channelSize
     * @param int  $itemSize
     * @param bool $isLazyLoad
     */
    public function testMemoryUsage($channelSize, $itemSize, $isLazyLoad)
    {
        $memory = memory_get_usage();

        $rss   = self::getRSS($channelSize, $itemSize, $isLazyLoad);
        $write = self::getWriter();
        $write->write($rss);

        $memory = memory_get_usage() - $memory;

        if (self::$memory_usage === null) {
            self::$memory_usage = $memory;
        }

        if ($isLazyLoad) {
            $this->assertLessThanOrEqual(self::$memory_usage, $memory);
        } else {
            $this->assertGreaterThanOrEqual(self::$memory_usage, $memory);
        }

        self::$memory_usage = $memory;
    }

    /**
     * @return Writer
     */
    protected static function getWriter()
    {
        return new Writer(function ($string) {
        });
    }

    /**
     * @param int  $channelSize
     * @param int  $itemSize
     * @param bool $isLazyLoad
     * @return RSS
     */
    protected static function getRSS($channelSize, $itemSize, $isLazyLoad)
    {
        $rss = new RSS();

        $rss->setChannels(self::getChanelIterator($channelSize, $itemSize, $isLazyLoad));

        return $rss;
    }

    /**
     * @param int  $channelSize
     * @param int  $itemSize
     * @param bool $isLazyLoad
     * @return \Iterator
     */
    protected static function getChanelIterator($channelSize, $itemSize, $isLazyLoad)
    {
        $generator = function () use ($channelSize, $itemSize, $isLazyLoad) {
            for ($i = 0; $i < $channelSize; $i++) {
                $channel = new Channel('title ' . $i, 'link ' . $i, 'description ' . $i);

                $channel->setItems(self::getItemIterator($itemSize, $isLazyLoad));

                yield $channel;
            }
        };

        return $isLazyLoad ? $generator() : new \ArrayIterator(iterator_to_array($generator()));
    }

    /**
     * @param int  $itemSize
     * @param bool $isLazyLoad
     * @return \Iterator
     */
    protected static function getItemIterator($itemSize, $isLazyLoad)
    {
        $generator = function () use ($itemSize) {
            for ($i = 0; $i < $itemSize; $i++) {
                $item = new Item();

                $item
                    ->setDescription('description ' . $i)
                    ->setTitle('title ' . $i);

                yield $item;
            }
        };

        return $isLazyLoad ? $generator() : new \ArrayIterator(iterator_to_array($generator()));
    }
}
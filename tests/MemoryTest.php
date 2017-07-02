<?php namespace Utlime\RSS;

use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    protected static $memory_usage = null;

    /**
     * @return array|array[]
     */
    public function additionSize()
    {
        return [
            'Size 100'     => [10, 10],
            'Size 1000'    => [100, 10],
            'Size 10000'   => [100, 100],
            'Size 100000'  => [1000, 100],
        ];
    }

    /**
     * @dataProvider additionSize
     * @param int $channelSize
     * @param int $itemSize
     */
    public function testLazyLoadMemoryUsage($channelSize, $itemSize)
    {
        $memory = memory_get_usage();

        $rss   = self::getRSS($channelSize, $itemSize);
        $write = self::getWriter();
        $write->write($rss);

        $memory = memory_get_usage() - $memory;

        if (self::$memory_usage === null) {
            self::$memory_usage = $memory;
        }

        $this->assertLessThanOrEqual($memory, self::$memory_usage);

        self::$memory_usage = $memory;
    }

    /**
     * @dataProvider additionSize
     * @param int $channelSize
     * @param int $itemSize
     */
    public function testEagerLoadMemoryUsage($channelSize, $itemSize)
    {
        $memory = memory_get_usage();

        $rss   = self::getRSS($channelSize, $itemSize, true);
        $write = self::getWriter();
        $write->write($rss);

        $memory = memory_get_usage() - $memory;

        if (self::$memory_usage === null) {
            self::$memory_usage = $memory;
        }

        $this->assertGreaterThanOrEqual(self::$memory_usage, $memory);

        self::$memory_usage = $memory;
    }

    public static function setUpBeforeClass()
    {
        $rss   = self::getRSS(1, 1, true);
        $write = self::getWriter();
        $write->write($rss);
    }

    public static function tearDownAfterClass()
    {
        self::$memory_usage = null;
    }

    /**
     * @return Writer
     */
    protected static function getWriter()
    {
        return new Writer(function ($string) {});
    }

    /**
     * @param int  $channelSize
     * @param int  $itemSize
     * @param bool $eager
     * @return RSS
     */
    protected static function getRSS($channelSize, $itemSize, $eager = false)
    {
        $rss = new RSS();

        $rss->setChannels(self::getChanelIterator($channelSize, $itemSize, $eager));

        return $rss;
    }

    /**
     * @param int  $channelSize
     * @param int  $itemSize
     * @param bool $eager
     * @return \Iterator
     */
    protected static function getChanelIterator($channelSize, $itemSize, $eager = false)
    {
        $generator = function () use ($channelSize, $itemSize, $eager) {
            for ($i = 0; $i < $channelSize; $i++) {
                $channel = new Channel('title ' . $i, 'link ' . $i, 'description ' . $i);

                $channel->setItems(self::getItemIterator($itemSize, $eager));

                yield $channel;
            }
        };

        return $eager ? new \ArrayIterator(iterator_to_array($generator())) : $generator();
    }

    /**
     * @param int  $itemSize
     * @param bool $eager
     * @return \Iterator
     */
    protected static function getItemIterator($itemSize, $eager = false)
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

        return $eager ? new \ArrayIterator(iterator_to_array($generator())) : $generator();
    }
}
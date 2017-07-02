<?php

require "../vendor/autoload.php";

$item_iterator = function ($prefix) {
    for ($i = 0; $i < 3; $i++) {
        $item = new \Utlime\RSS\Item();

        $item->setTitle($prefix . ' title' . $i);

        yield $item;
    }
};

$channel_iterator = function () use ($item_iterator) {
    for ($i = 0; $i < 2; $i++) {
        $channel = new \Utlime\RSS\Channel('title' . $i, 'link' . $i, 'description' . $i);

        $channel->setItems($item_iterator('channel' . $i));

        yield $channel;
    }
};

$output = function ($string) {
    echo $string . "\r\n";
};

$rss = new \Utlime\RSS\RSS();
$rss->setChannels($channel_iterator());

$writer = new Utlime\RSS\Writer($output);
$writer->write($rss);
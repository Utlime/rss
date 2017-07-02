# php-rss-writer
Optimized RSS writer, which based on Iterator interface. This allow to implement Lazy Load pattern.

# Specification
https://validator.w3.org/feed/docs/rss2.html

# Installation
You can install directly via Composer:
```bash
$ composer require "utlime/php-rss-writer":"^1.0"
```

# Example
> examples/example.php
```php
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
```

# Feed format
```xml
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title></title>
        <link></link>
        <description></description>
        <language></language>
        <copyright></copyright>
        <pubDate></pubDate>
        <lastBuildDate></lastBuildDate>
        <category></category>
        <ttl></ttl>
        <item>
            <title></title>
            <link></link>
            <description></description>
            <category></category>
            <guid></guid>
            <pubDate></pubDate>
            <enclosure></enclosure>
        </item>
    </channel>
</rss>
```

# How to test
```bash
$ composer install --dev
$ vendor/bin/phpunit
```

# License
MIT license
<?php namespace Utlime\RSS;

/**
 * Class Channel
 * @package Utlime\RSS
 */
class Channel
{
    /** @var  string */
    protected $title;

    /** @var  string */
    protected $link;

    /** @var  string */
    protected $description;

    /** @var \Iterator|Item[] */
    protected $items;

    /** @var  string|null */
    protected $language;

    /** @var  string|null */
    protected $copyright;

    /** @var  \DateTimeInterface|null */
    protected $pubDate;

    /** @var  \DateTimeInterface|null */
    protected $lastBuildDate;

    /** @var  string|null */
    protected $category;

    /** @var  int|null */
    protected $ttl;

    /**
     * Channel constructor.
     * @param string $title
     * @param string $link
     * @param string $description
     */
    public function __construct($title, $link, $description)
    {
        $this->title       = $title;
        $this->link        = $link;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \Iterator|Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return null|string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return null|string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastBuildDate()
    {
        return $this->lastBuildDate;
    }

    /**
     * @return null|string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return int|null
     */
    public function getTTL()
    {
        return $this->ttl;
    }

    /**
     * @param null|string $language
     * @return Channel
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param null|string $copyright
     * @return Channel
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * @param \DateTimeInterface|null $pubDate
     * @return Channel
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * @param \DateTimeInterface|null $lastBuildDate
     * @return Channel
     */
    public function setLastBuildDate($lastBuildDate)
    {
        $this->lastBuildDate = $lastBuildDate;

        return $this;
    }

    /**
     * @param null|string $category
     * @return Channel
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param int|null $ttl
     * @return Channel
     */
    public function setTTL($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @param \Iterator|Item[] $items
     * @return Channel
     */
    public function setItems(\Iterator $items = null)
    {
        $this->items = $items;

        return $this;
    }
}
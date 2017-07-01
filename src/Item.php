<?php namespace Utlime\RSS;

/**
 * Class Item
 * @package Utlime\RSS
 */
class Item
{
    /** @var null|string */
    protected $title;

    /** @var null|string */
    protected $link;

    /** @var null|string */
    protected $description;

    /** @var null|string */
    protected $category;

    /** @var null|string */
    protected $guid;

    /** @var null|\DateTimeInterface */
    protected $pubDate;

    /** @var  null|array */
    protected $enclosure;

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return null|string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return null|string
     */
    public function getGUID()
    {
        return $this->guid;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @return array|null
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param null|string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param null|string $link
     * @return Item
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param null|string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param null|string $category
     * @return Item
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param null|string $guid
     * @return Item
     */
    public function setGUID($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * @param \DateTimeInterface|null $pubDate
     * @return Item
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * @param string $url
     * @param string $type
     * @param int    $length
     * @return Item
     * @internal param array|null $enclosure
     */
    public function setEnclosure($url, $type, $length)
    {
        $this->enclosure = ['url' => $url, 'type' => $type, 'length' => $length];

        return $this;
    }
}
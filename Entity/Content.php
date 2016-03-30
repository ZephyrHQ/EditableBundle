<?php

namespace Zephyr\EditableBundle\Entity;

/**
 * Content.
 */
class Content
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $content;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set page.
     *
     * @param string $page
     *
     * @return Content
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page.
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     *
     * @return Content
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return Content
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}

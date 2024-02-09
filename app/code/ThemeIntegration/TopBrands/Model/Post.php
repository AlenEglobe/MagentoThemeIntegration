<?php

namespace ThemeIntegration\TopBrands\Model;


use ThemeIntegration\TopBrands\Api\Data\GridInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'top_brands';

    /**
     * @var string
     */
    protected $_cacheTag = 'top_brands';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'top_brands';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('ThemeIntegration\TopBrands\Model\ResourceModel\Post');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getArticleId()
    {
        return $this->getData(self::ARTICLE_ID);
    }

    /**
     * Set EntityId.
     */
    public function setArticleId($articleId)
    {
        return $this->setData(self::ARTICLE_ID, $articleId);
    }

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getTitle()
    {
        return $this->getData(self::BRAND);
    }

    /**
     * Set Title.
     */
    public function setTitle($title)
    {
        return $this->setData(self::BRAND, $title);
    }

    // Get Image



    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }


    // Set Image


    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}

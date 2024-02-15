<?php

namespace ThemeIntegration\TopBrands\Model;


use ThemeIntegration\TopBrands\Api\Data\GridInterface;

use ThemeIntegration\TopBrands\Model\ResourceModel\Grid\CollectionFactory;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
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

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('ThemeIntegration\TopBrands\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getSortedCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('id', 'DESC');
        return $collection;
    }

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

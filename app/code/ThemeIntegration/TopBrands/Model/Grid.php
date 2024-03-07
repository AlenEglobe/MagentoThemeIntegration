<?php

namespace ThemeIntegration\TopBrands\Model;

use ThemeIntegration\TopBrands\Api\Data\GridInterface;
use ThemeIntegration\TopBrands\Model\ResourceModel\Grid\CollectionFactory;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * Cache tag for the top brands
     */
    public const CACHE_TAG = 'top_brands';

    /**
     * Cache tag for the top brands
     * @var string
     */
    protected $_cacheTag = 'top_brands';

    /**
     * Event prefix for top brands
     * @var string
     */
    protected $_eventPrefix = 'top_brands';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Grid constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
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

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\ThemeIntegration\TopBrands\Model\ResourceModel\Grid::class);
    }

    /**
     * Retrieve sorted collection
     *
     * @return \ThemeIntegration\TopBrands\Model\ResourceModel\Grid\Collection
     */
    public function getSortedCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('id', 'DESC');
        return $collection;
    }

    /**
     * Get EntityId
     *
     * @return int|null
     */
    public function getArticleId()
    {
        return $this->getData(self::ARTICLE_ID);
    }

    /**
     * Set EntityId
     *
     * @param int $articleId
     * @return $this
     */
    public function setArticleId($articleId)
    {
        return $this->setData(self::ARTICLE_ID, $articleId);
    }

    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::BRAND);
    }

    /**
     * Set Title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::BRAND, $title);
    }

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}

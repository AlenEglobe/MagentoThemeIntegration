<?php

namespace ThemeIntegration\ThemeModule\Block;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class ShoesList extends Template
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * ShoesList constructor.
     *
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryFactory = $categoryFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get shoes list under the category ID 23
     *
     * @return ProductCollection
     */
    public function getShoesList(): ProductCollection
    {
        $categoryId = 23; // Category ID for shoes
        $category = $this->categoryFactory->create()->load($categoryId);

        $products = $this->collectionFactory->create();

        $products->addAttributeToSelect('*');
        $products->addCategoryFilter($category);

        // $shoesCollection = $category->getProductCollection()->addAttributeToSelect('*');
        return $products;
    }

    public function getProductImageUrl($product)
    {

        $mediaBaseUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $image = $product->getImage();

        $imageUrl = $mediaBaseUrl . 'catalog/product/' . $image;
        return $imageUrl;
    }
}

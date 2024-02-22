<?php
namespace ThemeIntegration\ThemeModule\Block;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

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
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getShoesList()
    {
        $categoryId = 23; // Category ID for shoes
        $category = $this->categoryFactory->create()->load($categoryId);

        $shoesCollection = $this->collectionFactory->create();
        $shoesCollection->addAttributeToSelect('*')
            ->addCategoryFilter($category)
            ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

        return $shoesCollection;
    }
}
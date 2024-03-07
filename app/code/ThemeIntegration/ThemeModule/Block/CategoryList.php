<?php

namespace ThemeIntegration\ThemeModule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryList extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * CategoryList constructor.
     * @param Template\Context $context
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get category collection
     *
     * @return array
     */
    public function getCategoryCollection(): array
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('category_attribute1', 1);

        $categoryCollection = [];
        foreach ($collection as $category) {
            $categoryCollection[] = $category->getData();
        }

        return $categoryCollection;
    }
}

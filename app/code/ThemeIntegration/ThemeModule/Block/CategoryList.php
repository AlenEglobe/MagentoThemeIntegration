<?php

namespace ThemeIntegration\ThemeModule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryList extends Template
{
    protected $categoryCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCategoryCollection()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('category_attribute1', 1);
        foreach ($collection as $category) {
            $categoryCollection[] = $category->getData();
        }
        return $categoryCollection;
    }
}

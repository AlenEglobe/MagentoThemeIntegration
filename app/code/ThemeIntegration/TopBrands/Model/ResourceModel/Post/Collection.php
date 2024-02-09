<?php

namespace ThemeIntegration\TopBrands\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('ThemeIntegration\TopBrands\Model\Post', 'ThemeIntegration\TopBrands\Model\ResourceModel\Post');
    }
}

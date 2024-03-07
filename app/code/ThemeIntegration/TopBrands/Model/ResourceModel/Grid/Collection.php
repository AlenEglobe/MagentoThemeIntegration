<?php

namespace ThemeIntegration\TopBrands\Model\ResourceModel\Grid;

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
        $this->_init(\ThemeIntegration\TopBrands\Model\Grid::class, \ThemeIntegration\TopBrands\Model\ResourceModel\Grid::class);
    }
}

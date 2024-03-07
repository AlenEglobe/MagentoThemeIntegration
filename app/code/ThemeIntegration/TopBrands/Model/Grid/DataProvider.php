<?php

namespace ThemeIntegration\TopBrands\Model\Grid;

use ThemeIntegration\TopBrands\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var $loadedData
     */
    protected $loadedData;

    /**
     * Data provider constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string  $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems(); // your saved table data's collection model
        foreach ($items as $brand) {
            $brandData = $brand->getData();

            if ($brand->getImage()) {  // check images saved path from the database.
                $image_temp[0]['name'] = $brand->getImage();
                $image_temp[0]['url'] = $brand->getImage();
                $brandData['Image'] = $image_temp;
            }

            $this->loadedData[$brand->getArticleId()] = $brandData;
        }

        return $this->loadedData;
    }
}

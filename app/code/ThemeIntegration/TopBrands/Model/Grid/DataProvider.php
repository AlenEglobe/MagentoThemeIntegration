<?php

namespace ThemeIntegration\TopBrands\Model\Grid;

use ThemeIntegration\TopBrands\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;

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

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $brand) {
            $brandData = $brand->getData();
            $brand_img = $brandData['Image'];

            // Assuming $brand_img_url is defined and contains the image URL or path
            $brand_img_url = $brand_img; // Adjust this line according to your actual implementation

            unset($brandData['Image']); // Remove the original image data

            // Create a new array for the image data
            $brandData['Image'] = [
                [
                    'Brands' => $brand_img,
                    'Image' => $brand_img_url,
                ]
            ];

            $this->loadedData[$brand->getEntityId()] = $brandData;
        }

        return $this->loadedData;
    }
}

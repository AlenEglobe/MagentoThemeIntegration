<?php

namespace ThemeIntegration\TopBrands\Model\Grid;

use ThemeIntegration\TopBrands\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    private $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

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

    // public function getMediaUrl($imagePath)
    // {
    //     $mediaUrl = $this->storeManager->getStore()
    //         ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'imageUploader/images/' . $imagePath;
    //     return $mediaUrl;
    // }
}

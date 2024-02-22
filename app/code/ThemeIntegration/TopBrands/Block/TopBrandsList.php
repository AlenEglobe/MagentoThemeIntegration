<?php

namespace ThemeIntegration\TopBrands\Block;

use Magento\Framework\View\Element\Template;
use ThemeIntegration\TopBrands\Model\GridFactory;
use Magento\Store\Model\StoreManagerInterface;

class TopBrandsList extends Template
{
    /**
     * @var GridFactory
     */
    protected $gridFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * TopBrandsBlock constructor.
     * @param Template\Context $context
     * @param GridFactory $gridFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        GridFactory $gridFactory,
        StoreManagerInterface $storeManager,

        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->gridFactory = $gridFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get top brands data
     *
     * @return array
     */
    public function getTopBrands()
    {
        $brands = [];
        $gridCollection = $this->gridFactory->create()->getCollection();
        foreach ($gridCollection as $item) {
            // $imageUrl = $item->getImage();
            // Remove base URL from image URL
            // $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            // $imagePath = str_replace($baseUrl, '', $imageUrl);

            $brands[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'image' => $item->getImage(),
            ];
        }
        return $brands;
    }
}

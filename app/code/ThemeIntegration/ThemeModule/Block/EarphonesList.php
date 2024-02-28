<?php

namespace ThemeIntegration\ThemeModule\Block;


use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\Data\Form\FormKey;

class EarphonesList extends Template
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var FormKey
     */
    protected $formKey;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    protected $productRepository;

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
        \Magento\Catalog\Model\ProductRepository $productRepository,
        FormKey $formkey,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryFactory = $categoryFactory;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->formkey = $formkey;
    }

    /**
     * Get shoes list under the category ID 23
     *
     * @return ProductCollection
     */
    public function getEarphonesList(): ProductCollection
    {
        $categoryId = 20;
        $category = $this->categoryFactory->create()->load($categoryId);
        $products = $this->collectionFactory->create();
        $products->addAttributeToSelect('*');
        $products->addCategoryFilter($category);

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

    public function getSimpleProduct($configProductId)
    {

        $configProduct = $this->productRepository->getById($configProductId); // get the configurable product using its id .

        $simpleProductArray = $configProduct->getTypeInstance()->getUsedProducts($configProduct);

        foreach ($simpleProductArray as $product) {

            $simpleProduct[] = [
                'id' => $product->getId(),
                'title' => $product->getName(),
                'image' => $product->getData('image'),
                'sku' => $product->getSku(),
                'color' => $product->getAttributeText('color'),
            ];
        }



        return $simpleProduct;
    }

    public function getProductId($product)
    {
        $productId = $product->getId();
        return $productId;
    }

    public function getSimpleProductImageUrl($simpleProductId)
    {
        $mediaBaseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $simpleProduct = $this->productRepository->getById($simpleProductId);
        $image = $simpleProduct->getImage();
        $imageUrl = $mediaBaseUrl . 'catalog/product/' . $image;
        return $imageUrl;
    }

    public function getFormKeyForWishlist()
    {
        $formKey = $this->formkey->getFormKey();
        return $formKey;
    }
}

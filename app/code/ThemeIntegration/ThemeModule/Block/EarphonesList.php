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
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * EarphonesList constructor.
     *
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        FormKey $formKey,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryFactory = $categoryFactory;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->formKey = $formKey;
    }

    /**
     * Get earphones list under the category ID 20.
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

    /**
     * Get the image URL of a product.
     *
     * @param mixed $product
     *
     * @return string
     */
    public function getProductImageUrl($product): string
    {
        $mediaBaseUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $image = $product->getImage();
        $imageUrl = $mediaBaseUrl . 'catalog/product/' . $image;
        return $imageUrl;
    }

    /**
     * Get details of simple products associated with a configurable product.
     *
     * @param int $configProductId
     *
     * @return array
     */
    public function getSimpleProduct(int $configProductId): array
    {
        $configProduct = $this->productRepository->getById($configProductId);
        $simpleProductArray = $configProduct->getTypeInstance()->getUsedProducts($configProduct);
        $simpleProduct = [];
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

    /**
     * Get the ID of a product.
     *
     * @param mixed $product
     *
     * @return int
     */
    public function getProductId($product): int
    {
        return $product->getId();
    }

    /**
     * Get the image URL of a simple product by its ID.
     *
     * @param int $simpleProductId
     *
     * @return string
     */
    public function getSimpleProductImageUrl(int $simpleProductId): string
    {
        $mediaBaseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $simpleProduct = $this->productRepository->getById($simpleProductId);
        $image = $simpleProduct->getImage();
        $imageUrl = $mediaBaseUrl . 'catalog/product/' . $image;
        return $imageUrl;
    }

    /**
     * Get the form key for wishlist.
     *
     * @return string
     */
    public function getFormKeyForWishlist(): string
    {
        return $this->formKey->getFormKey();
    }
}

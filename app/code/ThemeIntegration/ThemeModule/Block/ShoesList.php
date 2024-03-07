<?php

namespace ThemeIntegration\ThemeModule\Block;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\Data\Form\FormKey;

class ShoesList extends Template
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

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * ShoesList constructor.
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
     * Get shoes list under the category ID 23
     *
     * @return ProductCollection
     */
    public function getShoesList(): ProductCollection
    {
        $categoryId = 23;
        $category = $this->categoryFactory->create()->load($categoryId);

        $products = $this->collectionFactory->create();
        $products->addAttributeToSelect('*');
        $products->addCategoryFilter($category);

        return $products;
    }

    /**
     * Get product image URL
     *
     * @param \Magento\Catalog\Model\Product $product
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
     * Get simple product image URL
     *
     * @param int $simpleProductId The ID of the simple product.
     *
     * @return string
     */
    public function getSimpleProductImageUrl($simpleProductId): string
    {
        $mediaBaseUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $simpleProduct = $this->productRepository->getById($simpleProductId);
        $image = $simpleProduct->getImage();
        $imageUrl = $mediaBaseUrl . 'catalog/product/' . $image;

        return $imageUrl;
    }

    /**
     * Get simple product data
     *
     * @param int $configProductId
     *
     * @return array
     */
    public function getSimpleProduct($configProductId): array
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
     * Get product ID
     *
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return int
     */
    public function getProductId($product): int
    {
        $productId = $product->getId();
        return $productId;
    }

    /**
     * Get form key for wishlist
     *
     * @return string
     */
    public function getFormKeyForWishlist(): string
    {
        $formKey = $this->formKey->getFormKey();
        return $formKey;
    }
}

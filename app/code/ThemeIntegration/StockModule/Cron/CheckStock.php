<?php

namespace ThemeIntegration\StockModule\Cron;

use  Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
// use Magento\CatalogInventory\Api\StockItemRepositoryInterface;
// use Magento\CatalogInventory\Api\StockRepositoryInterface;
use Magento\InventoryApi\Api\SourceItemRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;


use Magento\Quote\Model\Cart\ProductReader;

class CheckStock
{
    protected $stockRegistry;

    protected $searchCriteriaBuilder;

    protected $searchCriteriaBuilderFactory;

    protected $productRepository;

    protected $stockItemRepository;

    protected $sourceItemRepository;

    protected $logger;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SourceItemRepositoryInterface $sourceItemRepository,
        LoggerInterface $logger,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory


    ) {
        $this->productRepository = $productRepository;
        $this->sourceItemRepository = $sourceItemRepository;
        $this->logger = $logger;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
    }
    public function execute()
    {
        // Get product stock below 50
        $products = $this->getProductsBelowThreshold(50);

        // Perform action for each product
        foreach ($products as $product) {
            // Perform action, e.g., send alert
            $this->sendAlert($product);
        }
    }


    protected function getProductsBelowThreshold($threshold)
    {
        // Fetch products with stock below threshold
        // Example implementation:
        $products = []; // Array of products
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteria = $searchCriteriaBuilder->create();
        $allProducts = $this->productRepository->getList($searchCriteria)->getItems();
        foreach ($allProducts as $product) {

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('sku', $product->getSku(), 'eq')
                ->create();


            $sourceItems = $this->sourceItemRepository->getList($searchCriteria)->getItems();
            $stockQty = 0;
            foreach ($sourceItems as $sourceItem) {
                $stockQty += $sourceItem->getQuantity();
            }
            if ($stockQty < $threshold) {
                $products[] = $product;
            }
        }



        return $products;
    }

    protected function sendAlert($product)
    {
        // Example: Log product alert
        $this->logger->info('Product stock is below 50: ' . $product->getName());
        // Example: Send email alert
        // Implement your email sending logic here
    }
}

    <?php

    namespace ThemeIntegration\StockModule\Cron;

    use Magento\Catalog\Api\ProductRepositoryInterface;

    use Magento\InventoryApi\Api\SourceItemRepositoryInterface;
    use Psr\Log\LoggerInterface;

    use Magento\Framework\Api\SearchCriteriaBuilderFactory;

    use Magento\Framework\Mail\Template\TransportBuilder;
    use Magento\Store\Model\StoreManagerInterface;

    use Magento\Framework\App\Config\ScopeConfigInterface;

    class CheckStock
    {
        protected $stockRegistry;

        protected $searchCriteriaBuilder;

        protected $searchCriteriaBuilderFactory;

        protected $productRepository;

        protected $stockItemRepository;

        protected $sourceItemRepository;

        protected $logger;

        protected $transportBuilder;

        protected $storeManager;

        protected $scopeConfig;

        public function __construct(
            ProductRepositoryInterface $productRepository,
            SourceItemRepositoryInterface $sourceItemRepository,
            LoggerInterface $logger,
            SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
            TransportBuilder $transportBuilder,
            StoreManagerInterface $storeManager,
            ScopeConfigInterface $scopeConfig
        ) {
            $this->productRepository = $productRepository;
            $this->sourceItemRepository = $sourceItemRepository;
            $this->logger = $logger;
            $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
            $this->searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();

            $this->transportBuilder = $transportBuilder;
            $this->storeManager = $storeManager;
            $this->scopeConfig = $scopeConfig;
        }
        public function execute()
        {
            // Get product stock below 50
            $products = $this->getProductsBelowThreshold(30);

            // Perform action for each product
            foreach ($products as $product) {
                // Perform action, e.g., send alert
                $this->sendAlert($product, $product->getName());
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
        protected function sendAlert($product, $productName)
        {
            // Prepare email content
            $subject = 'Product Stock Alert';
            $message = 'The stock of product "' . $product->getName() . '" is below 50.';
            $templateParams =
                ['product_name' => $productName];


            try {
                // Send email


                $store = $this->storeManager->getStore();
                // $senderEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getId());
                // $senderName = $this->scopeConfig->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getId());
                $customEmail = 'alen.george@eglobeits.com';
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier('lowStock_template')
                    ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                    ->setTemplateVars($templateParams)
                    ->setFromByScope(['email' => 'alen.george@eglobeits.com', 'name' => 'Sender'])
                    ->addTo($customEmail)
                    ->getTransport();

                $transport->sendMessage();
                $this->logger->info('Product stock alert email sent for: ' . $product->getName());
            } catch (\Exception $e) {
                $this->logger->error('Error sending product stock alert email: ' . $e->getMessage());
            }
        }
    }

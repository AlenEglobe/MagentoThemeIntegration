<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;

/**
 * Class Index is used to create and return the top brands cms page
 *
 * @param Egits\Integration\Controller\Adminhtml\Index
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Holds and instance of the page factory
     *
     * @var bool|\Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;
    // protected $_postFactory;

    /**
     * Default index constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {

        $this->resultPageFactory = $resultPageFactory;
        // $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Default execute method which creates and returns the cms page
     *
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // $collection =  $this->_postFactory->create();
        // $data = $collection->getCollection();
        // print_r($data->getData());
        // die();
        $testVariable = 1;
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('The Top Brands Page')));

        return $resultPage;
    }
}

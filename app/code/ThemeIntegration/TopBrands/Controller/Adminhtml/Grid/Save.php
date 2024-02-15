<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use ThemeIntegration\TopBrands\Model\GridFactory;

class Save extends Action
{
    protected $brandFactory;

    public function __construct(
        Action\Context $context,
        GridFactory $brandFactory
    ) {
        parent::__construct($context);
        $this->brandFactory = $brandFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('*/*/add');
            return;
        }

        $brandModel = $this->brandFactory->create();
        $brandModel->setData($data);
        $brandModel->save();

        $this->messageManager->addSuccessMessage(__('Brand saved successfully.'));
        $this->_redirect('*/*/');
    }
}

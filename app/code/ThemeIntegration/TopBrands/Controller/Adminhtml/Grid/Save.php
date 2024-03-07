<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\AlreadyExistsException;
use ThemeIntegration\TopBrands\Model\Grid;
use ThemeIntegration\TopBrands\Model\ResourceModel\Grid as ResourceModel;
// use Magento\Framework\Message\ManagerInterface;
use function Endroid\QrCode\ImageData\getImage;

class Save extends Action
{
    /**
     * For Model
     *
     * @var Grid
     */
    protected Grid $grid;
    /**
     * for Resource model
     *
     * @var ResourceModel
     */
    protected ResourceModel $ResourceModel;
    /**
     * For Manager Interface
     *
     * @var ManagerInterface
     */
    // protected ManagerInterface $messageManager;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param Grid $grid
     * @param ResourceModel $ResourceModel
     */
    public function __construct(
        Action\Context $context,
        Grid $grid,
        ResourceModel $ResourceModel,
        // ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->grid = $grid;
        $this->ResourceModel = $ResourceModel;
        // $this->messageManager = $messageManager;
    }

    /**
     * Main function
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws AlreadyExistsException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $ModelData = $this->grid;
        $id = $this->getRequest()->getParam('id');
        $data = $this->getRequest()->getParams();
        //        var_dump($data['image'][0]['url']);
        //        dd();
        if ($id) {
            // $ModelData = $this->ResourceModel->getById($id);
            // if (!$ModelData->getArticleId()) {
            //     $this->messageManager->addErrorMessage('Invalid ID.');
            //     return $resultRedirect->setPath('*/*/');
            // }
            $ModelData->setArticleId($data['id']);
            $ModelData->setTitle($data['Brands']);
            $ModelData->setImage($data['Image'][0]['url']);
        } else {
            $ModelData->setTitle($data['Brands']);
            $ModelData->setImage($data['Image'][0]['url']);
        }
        $this->ResourceModel->save($ModelData);
        $this->messageManager->addSuccessMessage('The data has been saved.');
        // if ($this->getRequest()->getParam('back')) {
        //     return $resultRedirect->setPath('brands/index/add');
        // }

        return $resultRedirect->setPath('topbrands/grid/index');
    }
}

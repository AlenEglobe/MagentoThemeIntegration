<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use ThemeIntegration\TopBrands\Model\GridFactory;
use ThemeIntegration\TopBrands\Model\ResourceModel\Grid as ResourceModel;

class Delete extends Action
{
    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * @var Grid
     */
    protected $gridFactory;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param ResourceModel $resourceModel
     * @param Grid $gridFactory
     */
    public function __construct(
        Action\Context $context,
        ResourceModel $resourceModel,
        GridFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->resourceModel = $resourceModel;
        $this->gridFactory = $gridFactory;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            try {

                $model = $this->gridFactory->create()->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The item does not exist.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while deleting the item.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Unable to find the item to delete.'));
        }

        return $resultRedirect->setPath('topbrands/grid/index');
    }
}

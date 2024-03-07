<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

class Image extends Action
{

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * Image constructor.
     *
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute file upload action
     *
     * @return Json
     */
    public function execute(): Json
    {
        /** @var Json $jsonResult */
        $jsonResult = $this->resultJsonFactory->create();
        try {
            $fileUploader = $this->uploaderFactory->create(['fileId' => 'Image']);
            $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowCreateFolders(true);
            $fileUploader->setFilesDispersion(false);
            $result = $fileUploader->validateFile();
            if (!$result) {
                throw new LocalizedException(__('Invalid file type or size.'));
            }
            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath('tmp/imageUploader/images'));
            $result['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                . 'tmp/imageUploader/images/' . ltrim(str_replace('\\', '/', $result['file']), '/');
            return $jsonResult->setData($result);
        } catch (LocalizedException $e) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => $e->getMessage()]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            return $jsonResult->setData(['errorcode' => 0,'error' => __('An error occurred, please try again later.')]);
        }
    }
}

<?php

namespace ThemeIntegration\TopBrands\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var \VENDOR\ImageUploader\Model\ImageFactory
     */
    protected $gridFactory;

    /** 
     * @var Filesystem\Directory\WriteInterface 
     */
    protected $mediaDirectory;


    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        \ThemeIntegration\TopBrands\Model\GridFactory $gridFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->gridFactory = $gridFactory;
        $this->storeManager = $storeManager;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }

    public function execute()
    {
        $baseurl = $this->storeManager->getStore()->getBaseUrl();
        try {
            if ($this->getRequest()->getMethod() !== 'POST' || !$this->_formKeyValidator->validate($this->getRequest())) {
                throw new LocalizedException(__('Invalid Request'));
            }

            //validate image
            $fileUploader = null;
            $params = $this->getRequest()->getParams();
            try {
                $imageId = 'Image';
                if (isset($params['Image']) && count($params['Image'])) {
                    $imageId = $params['Image'][0];
                    if (!file_exists($imageId['tmp_name'])) {
                        $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
                    }
                }
                $fileUploader = $this->uploaderFactory->create(['fileId' => $imageId]);
                $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                $fileUploader->setAllowRenameFiles(true);
                $fileUploader->setAllowCreateFolders(true);
                $fileUploader->validateFile();
                //upload image
                $info = $fileUploader->save($this->mediaDirectory->getAbsolutePath('imageUploader/images'));
                /** @var \VENDOR\ImageUploader\Model\Image */
                $image = $this->gridFactory->create();
                // $image->setImage($this->mediaDirectory->getRelativePath('imageUploader/images') . '/' . $info['file']);
                $image->save();
            } catch (ValidationException $e) {
                throw new LocalizedException(__('Image extension is not supported. Only extensions allowed are jpg, jpeg and png'));
            } catch (\Exception $e) {
                //if an except is thrown, no image has been uploaded
                throw new LocalizedException(__('Image is required'));
            }

            $brandName = isset($params['Brands']) ? $params['Brands'] : '';
            if (!empty($brandName)) {
                /** @var \VENDOR\ImageUploader\Model\Image */
                $image = $this->gridFactory->create();
                $image->setImage($this->mediaDirectory->getRelativePath($baseurl . 'media/imageUploader/images') . '/' . $info['file']);
                $image->setTitle($brandName); // Assuming you have a setter method in your model
                $image->save();
            } else {
                throw new LocalizedException(__('Brand name is required'));
            }

            $this->messageManager->addSuccessMessage(__('Image and brand name uploaded successfully'));

            return $this->_redirect('*/*/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('*/*/form');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $this->messageManager->addErrorMessage(__('An error occurred, please try again later.'));
            return $this->_redirect('*/*/form');
        }
    }
}

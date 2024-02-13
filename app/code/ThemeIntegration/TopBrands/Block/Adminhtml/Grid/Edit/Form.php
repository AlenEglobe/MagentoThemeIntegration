<?php

namespace ThemeIntegration\TopBrands\Block\Adminhtml\Grid\Edit;

use ThemeIntegration\TopBrands\Ui\Component\Listing\Grid\Column\PreviewImage;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );
        $form->setHtmlIdPrefix('smb_');
        if ($model->getArticleId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Article Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Article Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'Brands',
            'text',
            [
                'name' => 'Brands',
                'label' => __('Brands'),
                'id' => 'Brands',
                'title' => __('Brands'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'Image',
            'file',
            [
                'name' => 'Image',
                'label' => __('Image'),
                'id' => 'image',
                'title' => __('Image'),
                'class' => 'required-file',
                'required' => true,
                'note' => 'Allowed image types: JPG, JPEG, PNG, GIF',
                // 'renderer' => $this->getLayout()->createBlock(PreviewImage::class)
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
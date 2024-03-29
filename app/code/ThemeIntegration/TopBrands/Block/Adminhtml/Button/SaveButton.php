<?php

namespace ThemeIntegration\TopBrands\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class SaveButton extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'ui_form.ui_form',
                                'actionName' => 'save',
                                'params' => [
                                    false,
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // 'options' => $this->getOptions(),
        ];
    }
    // protected function getOptions()
    // {
    //     $options[] = [
    //         'id_hard' => 'save_and_new',
    //         'label' => __('Save & New'),
    //         'data_attribute' => [
    //             'mage-init' => [
    //                 'buttonAdapter' => [
    //                     'actions' => [
    //                         [
    //                             'targetName' => 'ui_form.ui_form',
    //                             'actionName' => 'save',
    //                             'params' => [
    //                                 true,
    //                                 [
    //                                     'back' => 'add',
    //                                 ],
    //                             ],
    //                         ],
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];
    //     $options[] = [
    //         'id_hard' => 'save_and_close',
    //         'label' => __('Save & Close'),
    //         'data_attribute' => [
    //             'mage-init' => [
    //                 'buttonAdapter' => [
    //                     'actions' => [
    //                         [
    //                             'targetName' => 'ui_form.ui_form',
    //                             'actionName' => 'save',
    //                             'params' => [
    //                                 true,
    //                                 [
    //                                     'back' => 'close',
    //                                 ],
    //                             ],
    //                         ],
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];
    //     return $options;
    // }
}

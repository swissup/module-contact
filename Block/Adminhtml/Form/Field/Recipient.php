<?php

namespace Swissup\Contact\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Recipient extends AbstractFieldArray
{
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('recipientName', ['label' => __('Recipient Name')]);
        $this->addColumn('recipient', ['label' => __('Recipient Email')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add recipient');
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}

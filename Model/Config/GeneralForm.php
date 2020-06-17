<?php

namespace Swissup\Contact\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Swissup\Contact\Block\ContactForm;

class GeneralForm extends \Magento\Contact\Model\Config
{
    /**
     * @var ContactForm
     */
    protected $form;

    /**
     * @param ContactForm          $form
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ContactForm $form,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->form = $form;
        parent::__construct($scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function emailRecipient()
    {
        $recipientName = $this->form->getRequest()->getParam('recipient');
        $options = $this->getRecipients() ?: [];
        $recipient = '';

        foreach ($options as $item) {
            if ($this->form->escapeHtmlAttr($item['recipientName']) === $recipientName) {
                $recipient = $item['recipient'];
            }
        }

        return $recipient ?: parent::emailRecipient();
    }

    /**
     * Get list of recipients
     *
     * @return array
     */
    public function getRecipients()
    {
        return $this->form->getGeneralFormOptions();
    }
}

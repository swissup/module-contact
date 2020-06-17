<?php

namespace Swissup\Contact\Model\Config;

use Magento\Store\Model\ScopeInterface;

class CallbackForm extends GeneralForm
{
    /**
     * {@inheritdoc}
     */
    public function getRecipients()
    {
        return $this->form->getCallbackFormOptions();
    }

    /**
     * {@inheritdoc}
     */
    public function emailTemplate()
    {
        return $this->config->getValue(
            'swissup_contact/callback/email_template',
            ScopeInterface::SCOPE_STORE
        );
    }
}

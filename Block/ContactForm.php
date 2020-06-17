<?php

namespace Swissup\Contact\Block;

use Magento\Framework\View\Element\Template;
use Swissup\Contact\Model\Config\Backend\Recipient as ConfigValueProcessor;

class ContactForm extends \Magento\Contact\Block\ContactForm
{
    /**
     * @var ConfigValueProcessor
     */
    protected $configValueProcessor;

    /**
     * @param ConfigValueProcessor $configValueProcessor
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        ConfigValueProcessor $configValueProcessor,
        Template\Context $context,
        array $data = []
    ) {
        $this->configValueProcessor = $configValueProcessor;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getGeneralFormOptions()
    {
        $value = $this->_scopeConfig->getValue('swissup_contact/general/purpose');

        return $this->configValueProcessor->makeArrayFieldValue($value);
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getGeneralFormAction()
    {
        return $this->getUrl('contact-us/index/post', ['_secure' => true]);
    }
}

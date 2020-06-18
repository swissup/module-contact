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
        $value = $this->_scopeConfig->getValue('swissup_contact/general/recipient');

        return $this->configValueProcessor->makeArrayFieldValue($value);
    }

    /**
     * @return array
     */
    public function getCallbackFormOptions()
    {
        $value = $this->_scopeConfig->getValue('swissup_contact/callback/recipient');

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

    /**
     * Returns action url for callback form
     *
     * @return string
     */
    public function getCallbackFormAction()
    {
        return $this->getUrl('contact-us/callback/post', ['_secure' => true]);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        $children = $this->getChildNames();
        if (!in_array('form.additional.info', $children)) {
            $this->addChild(
                'form.additional.info',
                \Magento\Captcha\Block\Captcha::class,
                [
                    'form_id' => 'contact_us',
                    'img_width' => '230',
                    'img_height' => '50'
                ]
            );
        }

        return parent::_prepareLayout();
    }
}

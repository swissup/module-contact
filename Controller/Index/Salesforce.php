<?php

namespace Swissup\Contact\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Salesforce extends Action
{
    private $formKeyValidator;

    private $helper;

    /**
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Captcha\Helper\Data                   $helper
     * @param Context                                        $context
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Captcha\Helper\Data $helper,
        Context $context
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $formId = 'contact_us';
        $captcha = $formId ? $this->helper->getCaptcha($formId) : null;

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->sendJson([
                    'status' => 'error',
                    'message' => __("Invalid Form Key. Please refresh the page.")
                ]);
        }

        if ($captcha && $captcha->isRequired()) {
            $token = $this->getRequest()->getParam('token', '');
            if (method_exists($captcha, 'verify')) {
                $response = $captcha->verify($token);
                $isSuccess = $response && $response->isSuccess();
            } else {
                $isSuccess = $captcha->isCorrect($token);
                $response = false;
            }

            if (!$isSuccess) {
                $errors = $response ? implode($response->getErrorCodes()) : '0';

                return $this->sendJson([
                    'status' => 'error',
                    'message' => __("Invalid recaptcha. [error-code: %1]", $errors)
                ]);
            }
        }

        return $this->sendJson([
            'status' => 'ok',
            'salesforceUrl' => 'https://culliganapec--apecfull.my.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8'
        ]);
    }

    /**
     * @param  array $data
     * @return \Magento\Framework\Controller\Result
     */
    private function sendJson($data) {
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($data);
    }
}

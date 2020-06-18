<?php

namespace Swissup\Contact\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Psr\Log\LoggerInterface;

class Post extends \Magento\Contact\Controller\Index\Post
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param \Magento\Captcha\Helper\Data                    $captchaHelper
     * @param \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver
     * @param Context                                         $context
     * @param ConfigInterface                                 $contactsConfig
     * @param MailInterface                                   $mail
     * @param DataPersistorInterface                          $dataPersistor
     * @param LoggerInterface|null                            $logger
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $captchaHelper,
        \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver,
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger = null
    ) {
        $this->captchaHelper = $captchaHelper;
        $this->captchaStringResolver = $captchaStringResolver;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $contactsConfig, $mail, $dataPersistor, $logger);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $formId = 'contact_us';
        $captcha = $this->captchaHelper->getCaptcha($formId);
        if ($captcha->isRequired()) {
            if (!$captcha->isCorrect($this->captchaStringResolver->resolve($this->getRequest(), $formId))) {
                $this->messageManager->addErrorMessage(__('Incorrect CAPTCHA.'));
                $this->dataPersistor->set($formId, $this->getRequest()->getPostValue());
                $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());

                return $resultRedirect;
            }
        }

        return parent::execute()->setUrl($this->_redirect->getRefererUrl());
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);
namespace Learning\StdCaptchaCustomForm\Observer;

use Magento\Captcha\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Captcha\Observer\CaptchaStringResolver;

class CustomFormObserver implements ObserverInterface
{

    /**
     *
     * @var Data
     */
    protected $_helper;

    /**
     *
     * @var ActionFlag
     */
    protected $_actionFlag;

    /**
     *
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     *
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     *
     * @var CaptchaStringResolver
     */
    protected $captchaStringResolver;

    /**
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     *
     * @param Data $helper
     * @param ActionFlag $actionFlag
     * @param ManagerInterface $messageManager
     * @param RedirectInterface $redirect
     * @param CaptchaStringResolver $captchaStringResolver
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(Data $helper, ActionFlag $actionFlag, ManagerInterface $messageManager, RedirectInterface $redirect, CaptchaStringResolver $captchaStringResolver, DataPersistorInterface $dataPersistor)
    {
        $this->_helper = $helper;
        $this->_actionFlag = $actionFlag;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->captchaStringResolver = $captchaStringResolver;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Check CAPTCHA on Contact Us page
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $formId = 'custom_form';
        $captcha = $this->_helper->getCaptcha($formId);
        if ($captcha->isRequired()) {
            /** @var Action $controller */
            $controller = $observer->getControllerAction();
            if (! $captcha->isCorrect($this->captchaStringResolver->resolve($controller->getRequest(), $formId))) {
                $this->messageManager->addErrorMessage(__('Incorrect CAPTCHA.'));
                $this->dataPersistor->set($formId, $controller->getRequest()
                    ->getPostValue());
                $this->_actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
                $this->redirect->redirect($controller->getResponse(), 'customform/index/index');
            }
        }
    }
}

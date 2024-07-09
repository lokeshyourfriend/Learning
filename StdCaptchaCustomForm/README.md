Enable Standard Captcha on Custom form

1. Magento_Captcha is the module that needs to be use for enabling standard captcha on the form.

2. First step to include your form in the list of the options in available forms in Customer Configuration section in the magento admin store configuration section.

3. To make available your form in the list of available forms store configuration you need to create the etc/config.xml

4. To show the captcha, Your custom form has a container “form.additional.info”, you need to refer to that container and add a block in the container. 
 
5. Also you need to refer the block “head.components” and add the block that referencing the template "Magento_Captcha::js/components.phtml"
 
6. To validate the captcha you need to use the event “controller_action_predispatch_customform_index_post”
 
7. Write you observer and inject the necessary classes to validate the captcha

$formId = 'custom_form';

/** \Magento\Captcha\Helper\Data $helper **/
$captcha = $this->helper->getCaptcha($formId);

/**Magento\Captcha\Observer\CaptchaStringResolver**/
$result = $captcha->isValid($this->captchaStringResolver->resolve($controller->getRequest(), $formId));

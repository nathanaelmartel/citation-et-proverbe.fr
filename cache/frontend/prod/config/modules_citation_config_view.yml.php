<?php
// auto-generated by sfViewConfigHandler
// date: 2018/01/30 17:31:24
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Citations', false, false);
  $response->addMeta('language', 'fr', false, false);
  $response->addMeta('robots', 'index, follow', false, false);

  $response->addStylesheet('/sw-combine/frontend/459cb1dc4fa76b8c3948dfa4933b8890.css', '', array (  'media' => 'screen',));
  $response->addStylesheet('/sw-combine/frontend/390042e10202882b2c30dabbecc6543a.css', '', array (  'media' => 'screen',));
  $response->defineCombinedAssets(array (
  0 => '{package} `common` (auto-include) : /sw-combine/frontend/459cb1dc4fa76b8c3948dfa4933b8890.css => NULL',
  1 => '{stylesheets} media `screen` : /sw-combine/frontend/390042e10202882b2c30dabbecc6543a.css => array (
  0 => \'/css/main.css\',
)',
));



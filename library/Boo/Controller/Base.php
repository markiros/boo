<?php

class Boo_Controller_Base extends Zend_Controller_Action
{
    /**
     * @var Zend_Layout
     */
    protected $layout = null;

    /**
     * @var Zend_Log
     */
    protected $logger = null;

    /**
     * @var Zend_Auth
     */
    protected $auth = null;

    /**
     * @var Zend_Acl
     */
    protected $_acl = null;

    /**
     * @var Boo_Model_User
     */
    protected $userModel = null;

    /**
     * @var Zend_Config
     */
    protected $config = null;

    // Action Helpers
    protected $_redirector = null;

    /**
     * Инициализация
     */
    public function init()
    {
        parent::init();
        $this->layout = Zend_Layout::getMvcInstance();
        $this->logger = Zend_Registry::get('log');
        $this->config = Zend_Registry::get('config');

        // Action helpers
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    /**
     * Отключение Layout
     */
    public function disableLayout()
    {
        $this->_helper->layout->disableLayout();
        return $this;
    }

    /**
     * Отключение View
     */
    public function disableView()
    {
        $this->_helper->viewRenderer->setNoRender();
        return $this;
    }

    /**
     * Ajax?
     */
    public function isAjax()
    {
        return $this->getRequest()->isXmlHttpRequest();
    }

}


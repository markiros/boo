<?php

class Boo_Controller_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Log
     */
    protected $_logger = null;

    /**
     * @var Zend_Acl
     */
    protected $_acl = null;

    /**
     * @var Zend_Auth
     */
    protected $_auth = null;

    /**
     * @var string
     */
    protected $_identity = null;

    public function init()
    {
        $currentRoute = Zend_Controller_Front::getInstance()->getRouter();
        $routeName = $currentRoute->getCurrentRouteName();

        $this->_acl = Zend_Registry::get('acl');
        $this->_logger = Zend_Registry::get('log');
        $this->_auth = Zend_Auth::getInstance();

        if ($this->_auth->hasIdentity() && isset($this->_auth->getIdentity()->user_role)) {
            $role = $this->_auth->getIdentity()->user_role;
            $user_email = $this->_auth->getIdentity()->user_email;
        } else {
            $role = 'guest';
            $user_email = 'n/a';
        }

        $message = sprintf('User: %s | Role: %s | Route: %s | Is allowed: %s',
                        $user_email, $role, $routeName, $this->_acl->isAllowed($role, 'mvc:'.$routeName));

        $this->_logger->info($message);

        if (! $this->_acl->isAllowed($role, 'mvc:'.$routeName)) {
            throw new Zend_Controller_Dispatcher_Exception('Access denied', 404);
        }

        //_d($role);

/*
        if (! $this->isAllowed('mvc:'.$routeName)) {
            //_d( $this->isAllowed('mvc:'.$routeName) );
            //$this->_logger->info($this->isAllowed('mvc:'.$routeName));
            //throw new Exception('Access denied');
            print 'Access denied';
        }
        */
    }

    public function isAllowed($resource=null, $privilege=null)
    {
        $this->_logger->debug(sprintf('Requesting ACL with params: identity:%s, resource:%s, privilege:%s', $this->getIdentity(), $resource, $privilege));

        if (null === $this->_acl) {
            return null;
        }
//_d($this->getIdentity());
        return $this->_acl->isAllowed($this->getIdentity(), $resource, $privilege);
    }

    public function setIdentity($identity)
    {
        $this->_identity = $identity;
        return $this;
    }

    public function getIdentity()
    {
        if (null === $this->_identity) {
            $auth = Zend_Auth::getInstance();
            if (! $auth->hasIdentity()) {
                return 'guest';
            }
            $role = isset($auth->getIdentity()->user_role)
                  ? $auth->getIdentity()->user_role
                  : 'guest';
            $this->setIdentity($role);
        }
        else {
            $this->setIdentity('guest');
        }
_d($this->_identity);
        return $this->_identity;
    }

    public function direct($resource=null, $privilege=null)
    {
        return $this->isAllowed($resource, $privilege);
    }

}
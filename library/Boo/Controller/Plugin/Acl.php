<?php

class Boo_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    private $_acl = null;

    public function __construct(Zend_Acl $acl)
    {
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Как  и  в предыдущем примере, аутентифицированные пользователи будут иметь
        // роль  «пользователь»
        $role = (Zend_Auth::getInstance()->hasIdentity())
              ? 'member'
              : 'guest';

        //  В этом примере мы будем использовать контроллер в качестве ресурса.
        $resource = $request->getControllerName();

        if( ! $this->_acl->isAllowed($role, $resource, 'view')) {
            // Если недостаточно прав то мы перенаправляем его на страницу авторизации
            $request->setModuleName('hmp')
                    ->setControllerName('index')
                    ->setActionName('index');
        }
    }
}


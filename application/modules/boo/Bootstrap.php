<?php

class Boo_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initModuleResourceAutoloader()
    {
        $this->getResourceLoader()->addResourceTypes(array(
            'modelResource' => array(
                'path'      => 'models/resources',
                'namespace' => 'Resource',
            ),
        ));
    }

    protected function _initPlugins()
    {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('frontController');
        $front = $bootstrap->getResource('frontController');

        //$front->registerPlugin(new Admin_Plugin_AdminContext());
        //$front->registerPlugin(new Admin_Plugin_MyContext());
    }

}


<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Log
     */
    protected $_logger = null;

    /**
     * Setup the config
     */
    protected function _initConfig()
    {
        Zend_Registry::set('config', new Zend_Config($this->getOptions()));
    }

    /**
     * Setup the sessions
     */
    protected function _initSession()
    {
        Zend_Session::start();
    }

    /**
     * Setup the logging
     */
    protected function _initLog()
    {
        $logger = new Zend_Log();

        // production : пишем логи только в файл
        if ($this->getEnvironment() == 'production') {
            $writer_file = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log');
            $logger->addWriter($writer_file);
        }
        // development : пишем логи в файл и в Firebug
        elseif ($this->getEnvironment() == 'development') {
            $writer_file = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log');
            $writer_firebug = new Zend_Log_Writer_Firebug();
            $logger->addWriter($writer_file);
            $logger->addWriter($writer_firebug);
        }
        else {
            $writer_file = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/testing.log');
            $logger->addWriter($writer_file);
        }


        $this->_logger = $logger;
        $this->_logger->info('------------------------------------------------');
        $message = sprintf('REQUEST_URI: %s | REFERER: %s | USER_AGENT: %s | REMOTE_ADDR: %s',
                        arr($_SERVER, 'REQUEST_URI'),
                        arr($_SERVER, 'HTTP_REFERER', 'n/a'),
                        arr($_SERVER, 'HTTP_USER_AGENT'),
                        arr($_SERVER, 'REMOTE_ADDR') );
        $this->_logger->info($message);

        Zend_Registry::set('log', $logger);
    }

    /**
     * Setup the database
     */
    protected function _initDb()
    {
        $this->bootstrap('log');

        $db = $this->getPluginResource('db')->getDbAdapter();
        $db->query('SET NAMES UTF8');
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        Zend_Registry::set('db', $db);

        if ($this->getEnvironment() == 'development') {
            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
            $profiler->setEnabled(true);
            $this->getPluginResource('db')
                 ->getDbAdapter($db)
                 ->setProfiler($profiler);
        }

    }

    /**
     * Setup the routes
     */
    protected function _initRoutes()
    {
        $this->bootstrap('frontController');

        $config = new Zend_Config(require(APPLICATION_PATH . '/configs/routes.php'));
        $router = $this->frontController->getRouter();
        //$router->removeDefaultRoutes();
        $router->addConfig($config, 'routes');
    }

}


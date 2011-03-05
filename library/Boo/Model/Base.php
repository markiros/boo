<?php

abstract class Boo_Model_Base
{
    /**
     * @var Zend_Db
     */
    protected $db = null;

    /**
     * @var Zend_Log
     */
    protected $logger = null;

    /**
     * @var Zend_Config
     */
    protected $config = null;

    protected $params = null;

    public function __construct($params=array())
    {
        $this->params = $params;
        $this->db = Zend_Registry::get('db');
        $this->logger = Zend_Registry::get('log');
        $this->config = Zend_Registry::get('config');
        $this->init();
    }

    public function init()
    {
    }

}
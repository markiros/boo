<?php

class Boo_IndexController extends Zend_Controller_Action
{
    /////////////////////////////////////////////////////////////////////////////
    // Init
    /////////////////////////////////////////////////////////////////////////////
    public function init()
    {
        parent::init();
    }

    /////////////////////////////////////////////////////////////////////////////
    // Actions
    /////////////////////////////////////////////////////////////////////////////
    public function indexAction()
    {
    }

    public function todoAction()
    {
        $this->disableView();
        print 'TODO';
    }

    /**
     * ���������� Layout
     */
    public function disableLayout()
    {
        $this->_helper->layout->disableLayout();
        return $this;
    }

    /**
     * ���������� View
     */
    public function disableView()
    {
        $this->_helper->viewRenderer->setNoRender();
        return $this;
    }

}

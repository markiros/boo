<?php

class Boo_ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = '404. Page not found. RequestURI: '.$_SERVER['REQUEST_URI']; // $this->getRequest()->getrequestUri()
                break;

            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = '500. Internal server error';
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }

        // conditionally display exceptions
        //$this->_helper->layout->disableLayout();
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
            $this->render('error');
        }
        else {
            $this->render('error-404');
        }

        $this->view->request = $errors->request;
    }

    public function getLog()
    {
        return Zend_Registry::get('log');
    }


}


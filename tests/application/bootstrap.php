<?php

    // Define root path to public
    defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../'));

    // Define path to application directory
    defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

    // Define application environment
    define('APPLICATION_ENV', 'testing');

    // Ensure library/ is on include_path
    set_include_path(implode(PATH_SEPARATOR, array(
        get_include_path(),
        'D:\_www\home\markiros\www\library',
        'D:\_www\usr\local\library\Zend\library',
        'C:\_www\home\markiros\www\library',
        //'D:\_www\home\markiros\www\library',
        //'/ebsmnt/web/library',
        //'/ebsmnt/web/library/Zend/library',
        //'/web/library/Zend/library',
    )));

    // Set Locale
    date_default_timezone_set('Europe/Moscow');
    setlocale(LC_ALL, 'en');

    // Includes
    require_once 'Zend/Application.php';
    require_once 'ControllerTestCase.php';
    require_once 'functions.php';
//print '> ' . ROOT_PATH . '/library';


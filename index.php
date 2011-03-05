<?php

// Timer start
$in = microtime(true);
//--------------------------------------------------------------------------------------------------------------------

    // Define root path to public
    defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__)));

    // Define path to application directory
    defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

    // Define application environment
    defined('APPLICATION_ENV') || define('APPLICATION_ENV', trim(file_get_contents('.application')));

    // Is production host
    defined('IS_REMOTE') || define('IS_REMOTE', (file_exists('./.remote') ? true : false));
        
    // Ensure library/ is on include_path
    set_include_path(implode(PATH_SEPARATOR, array(
        ROOT_PATH . '/library',
        'D:\_www\home\markiros\www\library',
        '/ebsmnt/web/library',
        '/ebsmnt/web/library/Zend/library',
        '/web/library/Zend/library',
        get_include_path(),
    )));

    // Includes
    require_once 'Zend/Application.php';
    require_once 'functions.php';

    // Set Locale
    date_default_timezone_set('Europe/Moscow');
    setlocale(LC_ALL, 'en');

    // Create application, bootstrap, and run
    $application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
    );
    $application->bootstrap()->run();

//--------------------------------------------------------------------------------------------------------------------
// Timer stop
$time = microtime(true) - $in;
$memory = memory_get_peak_usage() / 1024;
if (arr($_SERVER, 'HTTP_X_REQUESTED_WITH') != 'XMLHttpRequest') {
    if (arr($_GET, 'timer') == 'on')
        $_SESSION['show_timer'] = 1;
    if (arr($_GET, 'timer') == 'off')
        unset($_SESSION['show_timer']);
    if (arr($_SESSION, 'show_timer')==1)
        print sprintf("<div style='font:10px Tahoma; border:solid 0px #ccc; background:#fff; padding:0px 3px; position:fixed;
            right:0px; bottom:0px; color:#fff; background:#c00' align='center'>%.3f sec / %d Kb</div>", $time, $memory);
}

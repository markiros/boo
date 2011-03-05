<?php

    function _d($var, $label=null, $echo=true) {
        // format the label
        $label = ($label===null) ? '' : rtrim($label) . ' ';

        // var_dump the variable into a buffer and keep the output
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // neaten the newlines and indents
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        if (PHP_SAPI == 'cli') {
            $output = PHP_EOL . $label
                    . PHP_EOL . $output
                    . PHP_EOL;
        } else {
            if(!extension_loaded('xdebug'))
                $output = htmlspecialchars($output, ENT_QUOTES);
            $output = '<pre>'. $label. $output. '</pre>';
        }
        if ($echo)
            echo($output);
        return $output;
    }

    function _f($formatString, $data=array()) {
        $formatString = str_replace(array_map(create_function('$s', "return \":\$s\";"), array_keys($data)), array_values($data), $formatString);
        return $formatString;
    }

    function arr($arr, $arr_key, $default_value=null) {
        if (is_array($arr) && isset($arr[$arr_key]))
            return $arr[$arr_key];
        return $default_value;
    }

    function shortDate($dateTimeStr) {
        $dt = strtotime($dateTimeStr);
        return date('d.m', $dt);
    }

    function strToDateTime($dateTimeStr, $showTime=true) {
        if ($showTime)
            return date('Y-m-d H:i:s', strtotime($dateTimeStr));
        else
            return date('Y-m-d', strtotime($dateTimeStr));
    }

    function ruDateTime($dateTimeStr, $showTime=true) {
        if ($dateTimeStr == '')
            return '';
        $dt = strtotime($dateTimeStr);
        setlocale(LC_ALL, 'ru_RU');
        if ($showTime)
            return date('d.m.Y, H:i', $dt);
        else
            return date('d.m.Y', $dt);
    }

    function ruDateTimeLong($dateTimeStr, $showTime=true) {
        $monthes_ru = array(1=>'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        if ($dateTimeStr == '')
            return '';
        $dt = strtotime($dateTimeStr);
        setlocale(LC_ALL, 'ru_RU');
        if ($showTime)
            return sprintf('%d %s %d, %s',  date('d', $dt),
                                            arr($monthes_ru, date('n', $dt)),
                                            date('Y', $dt),
                                            date('H:i', $dt));
        else
            return sprintf('%d %s %d',      date('d', $dt),
                                            arr($monthes_ru, date('n', $dt)),
                                            date('Y', $dt));
    }

    function ruDateTimeShort($dateTimeStr, $showTime=true) {
        $monthes_ru = array(1=>'янв.', 'фев.', 'мар.', 'апр.', 'мая', 'июня', 'июля', 'авг.', 'сен.', 'окт.', 'ноя.', 'дек.');
        if ($dateTimeStr == '')
            return '';
        $dt = strtotime($dateTimeStr);
        setlocale(LC_ALL, 'ru_RU');
        if ($showTime)
            return sprintf('%d %s %d, %s',  date('d', $dt),
                                            arr($monthes_ru, date('n', $dt)),
                                            date('Y', $dt),
                                            date('H:i', $dt));
        else
            return sprintf('%d %s %d',      date('d', $dt),
                                            arr($monthes_ru, date('n', $dt)),
                                            date('Y', $dt));
    }

    function isoDate($dateTimeStr) {
        $dt = strtotime($dateTimeStr);
        return date('Y-m-d\TH:i:s\Z', $dt);
    }

    function win2utf($stringWin) {
        return iconv('windows-1251', 'UTF-8', $stringWin);
    }

    function utf2win($stringUtf) {
        return iconv('UTF-8', 'windows-1251', $stringUtf);
    }

    function utf2koi($stringUtf) {
        return iconv('UTF-8', 'KOI8-R', $stringUtf);
    }

    function koi2utf($stringUtf) {
        return iconv('KOI8-R', 'UTF-8', $stringUtf);
    }

    function declension($digit, $expr, $onlyword=false) {
        if (!is_array($expr)) $expr = array_filter(explode(' ', $expr));
        if (empty($expr[2])) $expr[2]=$expr[1];
        $i = preg_replace('/[^0-9]+/s', '', $digit) % 100;
        if ($onlyword) $digit='';
        if ($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
        else {
            $i%=10;
            if ($i==1) $res=$digit.' '.$expr[0];
            elseif ($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
            else $res=$digit.' '.$expr[2];
        }
        return trim($res);
    }

    function _t($value) {
        $translator = Boo_Registry::get('translator');
        return $translator->translate($value);
    }

    function _log($message, $type='DEBUG') {
        $log_file = arr(arr(Boo_Registry::get('config'), 'general'), 'log.path').'debug.log';
        $fh = fopen($log_file, 'a');
        fprintf($fh, "[%s] [%s] %s\n", date('Y-m-d H:i:s'), $type, trim($message));
        fclose($fh);
    }

    function _fb($message, $type='DEBUG') {
        if (DEBUG) {
            require_once('FirePHPCore/FirePHP.class.php');
            $firephp = FirePHP::getInstance(true);
            $firephp->fb($message, FirePHP::WARN);
        }
    }

    function makeMultiOptions($arr, $params=array()) {
        if (!is_array($arr)) trigger_error('Array is not an array');
        if (!is_array($params) && empty($params)) trigger_error('Params is not an array');
        $key = $params['key'];
        $value = $params['value'];
        $options = array();
        foreach ($arr as $item) {
            $options[$item[$key]] = $item[$value];
        }
        return $options;
    }

    function format_money($value) {
        return number_format($value, 2, ',', ' ');
    }

    function ifsetor($var, $or) {
        return (isset($var) && !empty($var)) ? $var : $or;
    }

    function getDateByWeek($year, $week) {
        $Jan1 = mktime (1, 1, 1, 1, 1, $year);
        $iYearFirstWeekNum = (int) strftime("%W",mktime (1, 1, 1, 1, 1, $year));

        if ($iYearFirstWeekNum == 1)
            $week = $week - 1;

        $weekdayJan1 = date ('w', $Jan1);
        $FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
        $CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
        return ($CurrentMondayTS);
    }

    if(!function_exists('mime_content_type')) {

        function mime_content_type($filename) {

            $mime_types = array(

                'txt' => 'text/plain',
                'htm' => 'text/html',
                'html' => 'text/html',
                'php' => 'text/html',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
                'swf' => 'application/x-shockwave-flash',
                'flv' => 'video/x-flv',

                // images
                'png' => 'image/png',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'ico' => 'image/vnd.microsoft.icon',
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',

                // archives
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                'exe' => 'application/x-msdownload',
                'msi' => 'application/x-msdownload',
                'cab' => 'application/vnd.ms-cab-compressed',

                // audio/video
                'mp3' => 'audio/mpeg',
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',

                // adobe
                'pdf' => 'application/pdf',
                'psd' => 'image/vnd.adobe.photoshop',
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',

                // ms office
                'doc' => 'application/msword',
                'rtf' => 'application/rtf',
                'xls' => 'application/vnd.ms-excel',
                'ppt' => 'application/vnd.ms-powerpoint',

                // open office
                'odt' => 'application/vnd.oasis.opendocument.text',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );

            $ext = strtolower(array_pop(explode('.',$filename)));
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            }
            elseif (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }
            else {
                return 'application/octet-stream';
            }
        }
    }

    function is_email($email, $strict = FALSE) {
        if ($strict === TRUE) {
            $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
            $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
            $atom  = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
            $pair  = '\\x5c[\\x00-\\x7f]';
            $domain_literal = "\\x5b($dtext|$pair)*\\x5d";
            $quoted_string  = "\\x22($qtext|$pair)*\\x22";
            $sub_domain     = "($atom|$domain_literal)";
            $word           = "($atom|$quoted_string)";
            $domain         = "$sub_domain(\\x2e$sub_domain)*";
            $local_part     = "$word(\\x2e$word)*";
            $expression     = "/^$local_part\\x40$domain$/D";
        }
        else {
            $expression = '/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD';
        }
        return (bool) preg_match($expression, (string) $email);
    }

    function array_filter_fields($arr, $allowed_fields) {
        $res = array();
        foreach ($arr as $field=>$value)
            if (in_array($field, $allowed_fields))
                $res[$field] = $value;
        return $res;
    }

    function resize_image($sourceImage, $width, $height)
    {
        $sourceImage = realpath($sourceImage);

        // получаем тип файла
        $ext = strtolower(pathinfo($sourceImage, PATHINFO_EXTENSION));
        switch ($ext) {
            case "jpg":
            case "jpeg":
                $srcImage = @ImageCreateFromJPEG($sourceImage);
                break;
            case "gif":
                $srcImage = ImageCreateFromGIF($sourceImage);
                break;
            case "png":
                $srcImage = ImageCreateFromPNG($sourceImage);
                break;
            default:
                return -1;
            break;
        }
        $srcWidth  = ImageSX($srcImage);
        $srcHeight = ImageSY($srcImage);
        $ratioWidth  = $srcWidth / $width;
        $ratioHeight = $srcHeight / $height;
        if ($ratioWidth < $ratioHeight) {
            $destWidth  = $srcWidth / $ratioHeight;
            $destHeight = $height;
        }
        else {
            $destWidth  = $width;
            $destHeight = $srcHeight / $ratioWidth;
        }
        $resImage = ImageCreateTrueColor($destWidth, $destHeight);
        ImageCopyResampled($resImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
        unlink($sourceImage);
        switch ($ext) {
            case "jpg":
            case "jpeg":
                ImageJPEG($resImage, $sourceImage, 100);
                break;
            case "gif":
                ImageGIF($resImage, $sourceImage);
                break;
            case "png":
                ImagePNG($resImage, $sourceImage);
                break;
        }
        ImageDestroy($srcImage);
        ImageDestroy($resImage);
        $fileInfo = pathinfo($sourceImage);
        return $fileInfo['basename'];
    }


    function my_ucfirst($string, $e ='utf-8')
    {
        return $string;
        /*
        if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) {
            $string = mb_strtolower($string, $e);
            $upper = mb_strtoupper($string, $e);
                preg_match('#(.)#us', $upper, $matches);
                $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);
        }
        else {
            $string = ucfirst($string);
        }
        return $string;
        */
    }

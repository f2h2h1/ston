<?php
session_start();
define('DEBUG', false);
define('APP_PATH', './inc/');
define('CLASS_PATH', APP_PATH.'class/');

require APP_PATH.'entrance.php';
require CLASS_PATH.'error.class.php';

if (DEBUG) {
    //error_reporting(E_ALL);
} else {
    //error_reporting(0);
}
try {
    entrance();
} catch (Exception $e) {
    $error = array(
        "state" => -100,
        "msg" => "unexpected error",
        "errmsg" => $e->getMessage(),
    );
    errorE::outputHtml($error);
}


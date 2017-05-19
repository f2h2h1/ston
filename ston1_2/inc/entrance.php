<?php
function entrance() {
    $queryString = urldecode($_SERVER['QUERY_STRING']);
    $parameter = explode("/", $queryString);
    
    if (DEBUG) {
        printf("<pre>%s</pre>\n",var_export($_SERVER['QUERY_STRING'], true));
        printf("<pre>%s</pre>\n",var_export($parameter, true));
    }
    /*
    $module = $parameter[0];
    $controller = $parameter[1];
    $action = $parameter[2];
    */
    if (empty($parameter[0]) || $parameter[0] == "") {
        array_splice($parameter,0,1);
    }
    $controller = $parameter[0];
    $action = $parameter[1];
    
    $controller = empty($controller) ? 'index' : $controller;
    $action = empty($action) ? 'index' : $action;
    
	if (($controller != '' || !empty($controller)) && file_exists("inc/".$controller.".php")) {
        require 'config.php';
        require CLASS_PATH.'base.class.php';
        require CLASS_PATH.'database.class.php';
        require CLASS_PATH.'test.class.php';
		require APP_PATH.$controller.".php";

        $arr = get_class_methods($controller);
        if (DEBUG) {
            printf("<pre>%s</pre>\n",var_export($arr, true));
        }
        if (in_array($action, $arr)) {
            $test = new $controller($parameter);
            die($test->$action());
        } else {
            $error = array(
                "state" => -102,
                "msg" => "There's no action called ".$action,
                "errmsg" => $parameter,
            );
            errorE::outputHtml($error);
        }
    } else {
        $error = array(
            "state" => -101,
            "msg" => "There's no controller called ".$controller,
            "errmsg" => $parameter,
        );
        errorE::outputHtml($error);
    }
}
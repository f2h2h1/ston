<?php
class errorE {
    function output($result = null, $style = null) {
        if (DEBUG) {
            $error = $result;
        } else {
            $error['state'] = empty($result['state']) ? -999 : $result['state'];
        }
        $error['msg'] = empty($result['msg']) ? "unexpected error" : $result['msg'];
        
        if ($style == "html") {
            include(APP_PATH."error.php");
            exit;
        } else {
            die(json_encode($error, JSON_UNESCAPED_SLASHES));
        }
    }
    function outputHtml($result) {
        self::output($result, "html");
    }
    function outputJson($result) {
        self::output($result, "json");
    }
}
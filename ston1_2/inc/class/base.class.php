<?php
class base {
    function httpRequest($url, $data = null, $headers = null) {
        $result = array();
        if (!empty($url)) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                if (!empty($headers)) {
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                }
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                curl_setopt($curl, CURLOPT_HEADER, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                if ($http_status == 200) {
                    $result = array(
                        "state" => 1,
                        "msg" => $output,
                    );
                } else {
                    $result = array(
                        "state" => -1,
                        "msg" => $output,
                        "errmsg" => "http_status != 200",
                    );
                }
            } catch(PDOException $e) {
                $result = array(
                    "state" => -2,
                    "msg" => $e,
                    "errmsg" => $output,
                );
            }
        } else {
            $result = array(
                "state" => -3,
                "msg" => "url is empty",
            );
        }
        return $result;
    }
    function httpRequestFile($url, $filesrc, $filetype, $filename, $data = null) {
        $result = array();
        if (!empty($url) && !empty($filesrc) && !empty($filetype) && !empty($filename)) {
            $cfile = curl_file_create($filesrc, $filetype, $filename);
            if ($data == null || is_array($data)) {
                if ($data == null) {
                    $data = array("file" => $cfile);
                } else {
                    $data['file'] = $cfile;
                }
                $result = self::httpRequest($url, $data);
            } else {
                $result = array(
                    "state" => -2,
                    "msg" => "\$data is not a array",
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => "there is a parameter for the empty",
            );
        }
        return $result;
    }
    function getNoncestr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
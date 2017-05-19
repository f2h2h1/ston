<?php
class database extends base {

    private $dbh = null;
    //private $dataBaseConfig = array('dataBaseHost'=>'',);
    
    function init($dataBaseConfig = null) {
        $dataBaseConfig['dataBaseHost'] = empty($dataBaseConfig['dataBaseHost']) ? DATABASE_HOST : $dataBaseConfig['dataBaseHost'];
        $dataBaseConfig['dataBaseName'] = empty($dataBaseConfig['dataBaseName']) ? DATABASE_NAME : $dataBaseConfig['dataBaseName'];
        $dataBaseConfig['dataBaseServerPort'] = empty($dataBaseConfig['dataBaseServerPort']) ? DATABASE_SERVER_PORT : $dataBaseConfig['dataBaseServerPort'];
        $dataBaseConfig['dataBaseUserName'] = empty($dataBaseConfig['dataBaseUserName']) ? DATABASE_USERNAME : $dataBaseConfig['dataBaseUserName'];
        $dataBaseConfig['dataBasePassWord'] = empty($dataBaseConfig['dataBasePassWord']) ? DATABASE_PASSWORD : $dataBaseConfig['dataBasePassWord'];
        $dataBaseConfig['sourceName'] = "mysql:dbname={$dataBaseConfig['dataBaseName']};host={$dataBaseConfig['dataBaseHost']};port={$dataBaseConfig['dataBaseServerPort']}";
    
        try {// 创建连接
            $this->dbh = new PDO($dataBaseConfig['sourceName'], $dataBaseConfig['dataBaseUserName'], $dataBaseConfig['dataBasePassWord'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            $result = array(
                "state" => 1,
                "msg" => "database success inint",
            );
        } catch(PDOException $e) {// 检测连接
            $result = array(
                "state" => -1,
                "msg" => "database failed inint",
                "errmsg" => array($e->getMessage(), $dataBaseConfig),
            );
        }
        return $result;
    }
    
    function sqlExce($sql, $parameter = null, $model = false, $all = false) {
        $result = array();
        if (!empty($this->dbh)) {
            if (!empty($sql)) {
                if(!is_array($parameter) && !empty($parameter)) {
                    $parameter = array($parameter);
                }
                if (!empty($parameter)) {
                    $sth = $this->dbh->prepare($sql);
                    $affectedRows = $sth->execute($parameter);
                } else {
                    $affectedRows = $this->dbh->exec($sql);
                }
                if ($affectedRows > 0) {
                    if ($model) {
                        if ($all) {
                            $row = $sth->fetchAll(PDO::FETCH_BOTH);
                        } else {
                            $row = $sth->fetch(PDO::FETCH_BOTH);
                        }
                    }
                    $result = array(
                        "state" => 1,
                        "msg" => $row,
                        "affectedRows" => $affectedRows,
                    );
                } else {
                    $result = array(
                        "state" => -3,
                        "msg" => $row,
                        "affectedRows" => $affectedRows,
                        "errormsg" => "a sql statement execution failed",
                    );
                }
            } else {
                $result = array(
                    "state" => -2,
                    "msg" => "sql is empty",
                    "sql" => $sql,
                    "parameter" => $parameter,
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => "dbh is empty",
                "errormsg" => $this->dbh,
            );
        }
        return $result;
    }
    function sqlSelect($sql, $parameter = null) {
        return self::sqlExce($sql, $parameter, true, false);
    }
    function sqlSelectAll($sql, $parameter = null) {
        return self::sqlExce($sql, $parameter, true, true);
    }
}
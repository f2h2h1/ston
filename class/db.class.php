<?php
class db {
    
    private $pdo;//用来存放数据库连接的变量
    
    /*构造函数，初始化数据库连接*/
    public function __construct() {
        
        $dataBaseConfig = array();
        $dataBaseConfig['dataBaseHost'] = dataBaseHost;
        $dataBaseConfig['dataBaseName'] = dataBaseName;
        $dataBaseConfig['dataBaseServerPort'] = dataBaseServerPort;    
        $dataBaseConfig['dataBaseUserName'] = dataBaseUserName;
        $dataBaseConfig['dataBasePassWord'] = dataBasePassWord;

        $dataSourceName="mysql:dbname={$dataBaseConfig['dataBaseName']};host={$dataBaseConfig['dataBaseHost']};port={$dataBaseConfig['dataBaseServerPort']}";
        $dbclass = 'PDO';
        
        //printf("<pre>%s</pre>\n",var_export( $dataBaseConfig ,TRUE));
        
        try // 创建连接
        {
            $this->pdo = new $dbclass($dataSourceName, $dataBaseConfig['dataBaseUserName'], $dataBaseConfig['dataBasePassWord'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            //printf("<pre>%s</pre>\n",var_export( $this->pdo ,TRUE));
        }
        catch(PDOException $e) // 检测连接
        {
            die($e->getMessage());
        }
        
    }
    
    /*返回第一条查询记录*/
    public function fetch($sql, $params = array()) {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);
        if (!$result) {
            return false;
        } else {
            return $statement->fetch(pdo::FETCH_ASSOC);
        }
    }
    
    /*返回全部查询记录*/
    public function fetchAll($sql, $params = array(), $keyfield = '') {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);
        if (!$result) {
            return false;
        } else {
            if (!$result) {
                return false;
            } else {
                if (empty($keyfield)) {
                    return $statement->fetchAll(pdo::FETCH_ASSOC);
                } else {
                    $temp = $statement->fetchAll(pdo::FETCH_ASSOC);
                    $rs = array();
                    if (!empty($temp)) {
                        foreach ($temp as $key => &$row) {
                            if (isset($row[$keyfield])) {
                                $rs[$row[$keyfield]] = $row;
                            } else {
                                $rs[] = $row;
                            }
                        }
                    }
                    return $rs;
                }
            }
        }
    }

    /*返回某一列的最大值*/
    public function fetchMax($table, $column) {
        $temp="MAX(".$column.")";
        $sql="select ".$temp." from ".$table;
        
        //echo $sql;
        
        $result = $this->fetch($sql);
        
        //printf("<pre>%s</pre>\n",var_export( $result ,TRUE));
        
        if (!$result) {
            return false;
        } else {
            //$result=$$result[$temp];
            return $result[$temp];
        }
    }
    
    /*更新数据*/
    public function update($table, $data = array(), $params = array(), $glue = 'AND') {
        $fields = $this->implode($data, ',');
        $condition = $this->implode($params, $glue);
        $params = array_merge($fields['params'], $condition['params']);
        $sql = "UPDATE " . $table . " SET {$fields['fields']}";
        $sql .= $condition['fields'] ? ' WHERE '.$condition['fields'] : '';
        return $this->query($sql, $params);
    }
    
    /*插入数据，replace into 是insert into 的加强版，数据不存在时就插入一条新的记录，存在时就更新数据*/
    public function insert($table, $data = array(), $replace = FALSE) {
        $cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
        $condition = $this->implode($data, ',');
        return $this->query("$cmd " . $table . " SET {$condition['fields']}", $condition['params']);
    }
    
    /*删除数据*/
    public function delete($table, $params = array(), $glue = 'AND') {
        $condition = $this->implode($params, $glue);
        $sql = "DELETE FROM " . $table;
        $sql .= $condition['fields'] ? ' WHERE '.$condition['fields'] : '';
        return $this->query($sql, $condition['params']);
    }
    
    /*统计符合条件的行数*/
    public function fetchCount($sql, $params = array()) {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);
        if (!$result) {
            return false;
        } else {
            $temp=$statement->fetchAll(pdo::FETCH_NUM);
            $tempCount=count($temp);
            if($tempCount>1) {
                //echo"1777---$tempCount";echo"<br>";
                $rs=$tempCount;
            } else {
                $rs=$temp[0][0];
                $rs=(int)$rs;
            }
            return $rs;
        }
    }
    
    /*从结果集中的下一行获取第一列，$column=0即第一列，$column=1即第二列*/
    public function fetchColumn($sql, $params = array(), $column = 0) {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);
        if (!$result) {
            return false;
        } else {
            return $statement->fetchColumn($column);
        }
    } 
    
    /*执行普通的sql查询*/
    public function query($sql, $params = array()) {
        if (empty($params)) {
            
            //echo"<br>";echo $sql;
            
            $result = $this->pdo->exec($sql);
            
            //printf("<pre>%s</pre>\n",var_export( $result ,TRUE));
            
            return $result;
        }
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);
        if (!$result) {
            return false;
        } else {
            return $statement->rowCount();
        }
    }
    
    /*用来构造参数的函数*/
    private function implode($params, $glue = ',') {
        $result = array('fields' => ' 1 ', 'params' => array());
        $split = '';
        if (!is_array($params)) {
            $result['fields'] = $params;
            return $result;
        }
        if (is_array($params)) {
            $result['fields'] = '';
            foreach ($params as $fields => $value) {
                $result['fields'] .= $split . "`$fields` =  :$fields";
                $split = ' ' . $glue . ' ';
                $result['params'][":$fields"] = is_null($value) ? '' : $value;
            }
        }
        return $result;
    }    
}
?>
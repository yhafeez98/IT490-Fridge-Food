<?php

class db
{
    private $_pdo;
    private $_query;
    private $_error = false;

    private $host = "localhost";
    private $dbname = "test_food";
    private $username = "root";
    private $db_password = "";

    public function __construct()
    {
        try {
            $this->_pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->db_password);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }


    public function insert($table, $data)
    {
        ksort($data);
        $fieldNames = implode(',', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $stmt = $this->_pdo->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($stmt->execute()) {
            $response = [
                "status" => 'success',
                'lastInsertId' => $this->_pdo->lastInsertId()];
            return $response;
        } else {
            $response = ["status" => 'error',
                'error' => $stmt->errorInfo()];
            // $error = json_encode($error);
            return $response;
        }
    }


    public function query($sql, array $values = [])
    {
        $this->_error = false; // reset to false
        $this->_query = $this->_pdo->prepare($sql);

        if ($this->_query->execute()) {
            $this->data = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->_query->rowCount();
        } else {
            $this->_error = true;
        }
        return $this;
    }

    public function rowsCount($query)
    {
        $sth = $this->_pdo->prepare($query);
        //$sth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($sth->execute()) {
            return $sth->rowCount();
        } else {
            $error = $sth->errorInfo();
            $response = ['error' => $error];

            return $response;
        }

    }


    public function delete($table, $fieldname, $fieldvalue)
    {
        $check = "select * from $table where $fieldname = :fieldvalue";
        $statement = $this->_pdo->prepare($check);
        $statement->bindParam(':fieldvalue', $fieldvalue, PDO::PARAM_STR);
        $statement->execute();
        $count = $statement->rowCount();
        if ($count > 0) {
            $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->bindParam(':id', $fieldvalue, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response = ["status" => 'success'];
                return $response;
            } else {
                $response = ["status" => 'error',
                    'error' => $stmt->errorInfo()];
                // $error = json_encode($error);
                return $response;
            }
        } else {
            $response = ["status" => 'notfound'];
            // $error = json_encode($error);
            return $response;

        }


    }


    public function update($table, $data, $where)
    {
        ksort($data);
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = :$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= "$key = :$key";
            } else {
                $whereDetails .= " AND $key = :$key";
            }
            $i++;
        }
        $whereDetails = ltrim($whereDetails, ' AND ');
        $stmt = $this->_pdo->prepare("UPDATE $table SET $fieldDetails WHERE $whereDetails");
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($stmt->execute()) {
            $response = ["status" => 'success',
                'lastInsertId' => $this->_pdo->lastInsertId()];
            return $response;
        } else {
            $response = ["status" => 'error',
                'error' => $stmt->errorInfo()];
            // $error = json_encode($error);
            return $response;
        }

    }

    public function find_data($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ, $class = '')
    {
        return $this->select($sql, $array, $fetchMode, $class, true);
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ, $class = '', $single = null)
    {
        // Append select if it isn't appended.
        if (strtolower(substr($sql, 0, 7)) !== 'select ') {
            $sql = "SELECT " . $sql;
        }
        $stmt = $this->_pdo->prepare($sql);
        foreach ($array as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue("$key", $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue("$key", $value);
            }
        }
        if ($stmt->execute()) {
            if ($single == null) {
                return $fetchMode === PDO::FETCH_CLASS ? $stmt->fetchAll($fetchMode, $class) : $stmt->fetchAll($fetchMode);
            } else {
                return $fetchMode === PDO::FETCH_CLASS ? $stmt->fetch($fetchMode, $class) : $stmt->fetch($fetchMode);
            }
        } else {
            $error = $stmt->errorInfo();
            $error = json_encode($error);
            return $error;
        }

    }

    public function error()
    {
        return $this->_error;
    }

//    for fetch_all and fetch function
// use result['data'] in foreach loop for fetching data
// if result['status']=='error' than echo result['error'][2]
    public function fetch_All($q)
    {
        $stm = $this->_pdo->prepare($q);
        if ($stm->execute()) {
            $result = $stm->fetchAll();
            return ['status' => 'ok', 'data' => $result];
        } else {
            return ['status' => 'error', 'error' => $stm->errorInfo()];
        }

    }

    public function fetch_row($q)
    {
        $stm = $this->_pdo->prepare($q);
        if ($stm->execute()) {
            $result = $stm->fetch();
            return ['status' => 'ok', 'data' => $result];
        } else {
            return ['status' => 'error', 'error' => $stm->errorInfo()];
        }

    }

}

?>
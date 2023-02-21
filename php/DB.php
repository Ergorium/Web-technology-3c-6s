<?php
/**
 * Created by PhpStorm.
 * User: kayn23
 * Date: 18.12.2018
 * Time: 9:58
 */


$GLOBALS['config'] = parse_ini_file('config.ini');
class DB
{

    protected static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getPDO()
    {
        $host = '127.0.0.1';
        $db   = 'biblioteka';
        $user = 'root';
        $pass = 'example';
        $port = "3306";
        $charset = 'utf8mb4';
        $config = $GLOBALS['config'];
        if (self::$instance === null) {
            // $opt = array(
            //     \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            //     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            //     \PDO::ATTR_EMULATE_PREPARES => TRUE,
            // );
            // // $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
            $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['bd_database'] . ';charset=' . $config['db_char'] . ';port=' . $config['port'];
            $options = [
              \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
              \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
              \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            self::$instance = new \PDO($dsn, $user, $pass, $options);
        }
        return self::$instance;
    }

    /**
     * @param $sql
     * @return bool|PDOStatement
     */
    public static function sql($sql)
    {
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public static function getRows($sql)
    {
        return self::sql($sql)->fetchAll();
    }

    public static function getRow($sql)
    {
        return self::sql($sql)->fetch();
    }

    public static function get($sql)
    {
        return self::sql($sql)->rowCount();
    }

    /**
     * Выборка из таблицы
     * @param $table
     * @param array $arg
     * @return array
     */
    public static function select($table, $where = '', $limit = null)
    {
        $where = ($where != '') ? "WHERE $where" : '';
        $sql = "SELECT * FROM $table $where " . ($limit ? 'limit ' . $limit : ''
    );
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function selectOne($table, $where)
    {
        $where = ($where != '') ? "WHERE $where" : '';
        $sql = "SELECT * FROM $table $where";
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(); 
    }

    /**
     * @param $table
     * @param array $arg
     * @return int
     */
    public static function insert($table, $arg = [])
    {
        $param = '';
        $value = '';
        foreach ($arg as $key => $elem) {
            $param .= "`$key`,";
            $st = str_replace("'", "\'", $elem);
            $value .= "'$st',";
        }
        $param = substr($param, 0, -1);
        var_dump($param);
        echo '<br>';
        $value = substr($value, 0, -1);
        var_dump($value);
        $stmt = self::getPDO()->prepare("INSERT INTO $table($param) VALUES ($value)");
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            var_dump($e);
//            self::checkError($e);
            return false;
        }
    }

    /**
     * @param $table
     * @param array $arg
     * @param string $where
     * @return int
     */
    public static function update($table, $arg = [], $where = '')
    {
        #UPDATE FROM table SET поля where
        $param = '';
        foreach ($arg as $key => $elem) {
            $st = str_replace("'", "\'", $elem);
            $param .= "`$key`='$st',";
        }
        $param = substr($param, 0, -1);
        $where = ($where != '') ? "WHERE $where" : '';
        $stmt = self::getPDO()->prepare("UPDATE $table SET $param $where");
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
//            self::checkError($e);
            return false;
        }
    }

    /**
     * @param $table
     * @param string $where
     * @return int
     */
    public static function delete($table, $where = '')
    {
        $where = ($where != '') ? "WHERE $where" : '';
        $stmt = self::getPDO()->prepare("DELETE FROM $table $where");
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            //self::checkError($e);
            return false;
        }
    }

    public static function lastId()
    {
        return self::getPDO()->lastInsertId();
    }

    private static function checkError($e)
    {
        switch ($e->getCode()) {
            case 23000:
                dd('Поля должны быть уникальными');
                break;
            case 23502:
                dd('Полян не должны быть пустыми');
                break;
            case 23503:
                dd('Нарушена целостность данных');
                break;
            default:
                dd($e->getCode());
        }
    }
}
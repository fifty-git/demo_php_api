<?php
namespace Lib;

use Aura\Sql\ExtendedPdo;

/**
 *
 */
class SqlModel
{
    private $host = null;
    private $dbName = null;
    private $dbUsername = null;
    private $dbPassword = null;
    private $pdo = null;

    public function __construct()
    {
        $ini_array = parse_ini_file("bootstrap/dbconf.ini");
        $this->host = $ini_array['db-host'];
        $this->dbName = $ini_array['db-name'];
        $this->dbUsername = $ini_array['db-user'];
        $this->dbPassword = $ini_array['db-pass'];

        $extendedPdoDb = "mysql:host=".$this->host.";dbname=".$this->dbName;
        $extendedPdoUsername = $this->dbUsername;
        $extendedPdoPassword = $this->dbPassword;

        $this->pdo = new ExtendedPdo($extendedPdoDb, $extendedPdoUsername, $extendedPdoPassword);
    }


    public function query($statement)
    {
        try {
            $statementHandle = $this->pdo->query($statement);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $statementHandle;
    }

    /**
     * Use to INSERT an array of values
     */
    public function executeArrayValues($sql, $insertDataArr)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($insertDataArr);
        } catch (Exception $e) {
            $this->logError($e, $stmt);
        }
        return $stmt;
    }

    /**
     * Use to SELECT using an array of values as with a IN() statement
     */
    public function executeArrayValuesSelect($sql, $selectDataArr)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($selectDataArr);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
    }

    public function rowCount($statementHandle)
    {
        $statement = "This was a rowCount() query";
        try {
            return $statementHandle->rowCount();
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
    }

    public function fetchAllStatementHandle($statementHandle)
    {
        $statement = "This was a PDO::FETCH_ASSOC query";
        try {
            return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
    }

    public function perform($statement, $bindValues = array())
    {
        try {
            $statementHandle = $this->pdo->perform($statement, $bindValues);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $statementHandle;
    }

    public function fetchAll($statement, $bindValues = array())
    {
        try {
            $result = $this->pdo->fetchAll($statement, $bindValues);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $result;
    }

    public function fetchFirstRow($statement, $bindValues = array())
    {
        try {
            $result = $this->pdo->fetchOne($statement, $bindValues);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $result;
    }

    public function fetchFirstField($statement, $bindValues = array())
    {
        try {
            $result = $this->pdo->fetchValue($statement, $bindValues);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $result;
    }

    public function fetchAffected($statement, $bindValues = array())
    {
        try {
            $result = $this->pdo->fetchAffected($statement, $bindValues);
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
        return $result;
    }

    public function insertId()
    {
        $statement = "This was a lastInsertId() query";
        try {
            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            $this->logError($e, $statement);
        }
    }

    public function getEnumValues($table, $field)
    {
        $sql = "desc {$table} {$field}";
        $st = $this->pdo->prepare($sql);

        if ($st->execute()) {
            $row = $st->fetch(PDO::FETCH_OBJ);
            if ($row === false) {
                return false;
            }

            $type_dec = $row->Type;
            if (substr($type_dec, 0, 5) !== 'enum(') {
                return false;
            }

            $values = array();
            foreach (explode(',', substr($type_dec, 5, (strlen($type_dec) - 6))) as $v) {
                array_push($values, trim($v, "'"));
            }

            return $values;
        }
        return false;
    }

    private function logError($e, $statement)
    {
        $message = $e->getMessage();

        $output = <<<HTML

----- SQL ERROR ---------------------------------------------
ERROR -----------
$message
STATEMENT -----------
$statement
FULL ERROR OUTPUT ----------
$e
----- END ---------------------------------------------------

HTML;

        error_log($output);
    }

    private function setDbConnection()
    {
        $urlArray = explode(".", $_SERVER['SERVER_NAME']);
        $devName = $urlArray[0];

        switch ($devName) {
            case 'staging':
                $con = 'staging';
                break;
            case 'dev1':
                $con = 'dev';
                break;
            case 'dev2':
                $con = 'dev';
                break;
            case 'dev3':
                $con = 'dev';
                break;
            case 'dev4':
                $con = 'dev';
                break;
            case 'dev5':
                $con = 'dev';
                break;
            case 'dev6':
                $con = 'dev';
                break;
            case 'dev7':
                $con = 'dev';
                break;
            case 'dev8':
                $con = 'dev';
                break;
            case 'dev9':
                $con = 'dev';
                break;
            case 'dev2':
                $con = 'dev2';
                break;
            default:
                $con = 'production';
        }

        return $con;
    }
}

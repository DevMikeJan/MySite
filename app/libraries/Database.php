<?php
namespace app\libraries; use PDO;

    class Database {
        private $dbHost = DB_HOST;
        private $dbUname = DB_USER;
        private $dbPass = DB_PASS;
        private $dbName = DBUSERS;

        private $statement;
        private $dbHandler;
        private $error;

        public function __construct() {
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $this->dbHandler = new PDO($conn, $this->dbUname, $this->dbPass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function conString($dbN) {
            $conn = 'mysql:host=' . $this->dbHost . ';dbname='. $dbN;
            return $conn;
        }

        public function openCon($dbN) {
            $returnVal;
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $dbN;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $returnVal = new PDO($conn, $this->dbUname, $this->dbPass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                $returnVal = $this->error;
            }

            return $returnVal;
        }


        //Allows us to write queries
        public function query($sql) {
            $this->statement = $this->dbHandler->prepare($sql);
        }

        //Bind values
        public function bind($parameter, $value, $type = null) {
            switch (is_null($type)) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            $this->statement->bindValue($parameter, $value, $type);
        }

        //Execute the prepared statement
        public function execute() {
            return $this->statement->execute();
        }

        //Return an array
        public function fetchAll() {
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

    

        //Return a specific row as an object
        public function single() {
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }


        //Get's the row count
        public function rowCount() {
            return $this->statement->rowCount();
        }
    }

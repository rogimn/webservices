<?php

    class Database
    {
        // specify your own database credentials

        private $type = 'mysql';
        private $host = 'db4free.net';
        private $port = '3306';
        private $dbname = 'webservices';
        private $user = 'webservices';
        private $pass = 'webservices';
        private $options = '--client_encoding=UTF8';
        public $conn;

        // get the database connection

        public function getConnection()
        {
            $this->conn = null;

            try {
                $this->conn = new PDO(''.$this->type.':host='.$this->host.';port='.$this->port.';options='.$this->options.';dbname='.$this->dbname.'', $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec('SET NAMES utf8');
            } catch (PDOException $exception) {
                echo 'Connection error: '.$exception->getMessage();
            }

            return $this->conn;
        }
    }

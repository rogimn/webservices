<?php

    class Professor
    {
        // database connection

        private $conn;

        // object properties

        public $id;
        public $nome;
        public $email;

        // constructor with $db as database connection

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // read all records

        public function readAll()
        {
            $sql = $this->conn->prepare("SELECT id,nome,email FROM professor ORDER BY nome,email");
            $sql->execute();

            return $sql;
        }
    }

    unset($db,$conn,$sql,$id,$nome,$semestres,$id_coordenador);

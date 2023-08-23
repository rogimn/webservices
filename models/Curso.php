<?php

    class Curso
    {
        // database connection

        private $conn;

        // object properties

        public $id;
        public $nome;
        public $semestres;
        public $id_coordenador;

        // constructor with $db as database connection

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // read all records

        public function readAll()
        {
            $sql = $this->conn->prepare("SELECT curso.*,professor.nome AS coordenador FROM curso INNER JOIN professor ON curso.id_coordenador = professor.id ORDER BY curso.nome, professor.nome");
            $sql->execute();

            return $sql;
        }
    }

    unset($db,$conn,$sql,$id,$nome,$semestres,$id_coordenador);

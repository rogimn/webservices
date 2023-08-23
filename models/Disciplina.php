<?php

    class Disciplina
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
            $sql = $this->conn->prepare("SELECT disciplina.*,curso.nome AS curso FROM disciplina INNER JOIN curso ON disciplina.id_curso = curso.id ORDER BY disciplina.nome, curso.nome");
            $sql->execute();

            return $sql;
        }
    }

    unset($db,$conn,$sql,$id,$nome,$semestres,$id_coordenador);

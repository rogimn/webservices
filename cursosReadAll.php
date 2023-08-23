<?php
    header("content-type: application/xml; charset=UTF-8");

    // call required files

    include_once 'config/Database.php';
    include_once 'models/Curso.php';

    // get database connection

    $database = new Database();
    $db = $database->getConnection();

    $curso = new Curso($db);
    $sql = $curso->readAll();

    if ($sql->rowCount() > 0) {
        $fileXML = 'xml/cursos.xml';
        
        $domDOC = new DOMDocument('1.0', 'UTF-8');
        $domIMP = new DOMImplementation();
        
        $cursosDTD = $domIMP->createDocumentType('cursos', '', 'dtd/cursos.dtd');
        $domDOC = $domIMP->createDocument('', '', $cursosDTD);
        $domDOC->formatOutput = true;

        $cursos = $domDOC->createElement('cursos');
        $domDOC->appendChild($cursos);

        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $curso = $domDOC->createElement('curso');
            $nome = $domDOC->createElement('nome', $row->nome);
            $semestres = $domDOC->createElement('semestres', $row->semestres);
            $coordenador = $domDOC->createElement('coordenador', $row->coordenador);

            $attr = $domDOC->createAttribute('id');
            $attr->value = $row->id;
            
            $curso->appendChild($attr);
            $cursos->appendChild($curso);
            $curso->appendChild($nome);
            $curso->appendChild($semestres);
            $curso->appendChild($coordenador);
        }

        if ($domDOC->validate()) {
            $domDOC->save($fileXML);
            echo 'DOC XML Válido!';
        } else {
            $domDOC->save($fileXML);
            echo 'DOC XML não Válido!';
        }
    } else {
        die('não deu boa!');   
    }

    unset($database,$db,$curso,$sql,$row);
    
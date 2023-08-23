<?php
    header("content-type: application/xml; charset=UTF-8");

    // call required files

    include_once 'config/Database.php';
    include_once 'models/Professor.php';

    // get database connection

    $database = new Database();
    $db = $database->getConnection();

    $professor = new Professor($db);
    $sql = $professor->readAll();

    if ($sql->rowCount() > 0) {
        $fileXML = 'xml/professores.xml';
        
        $domDOC = new DOMDocument('1.0', 'UTF-8');
        $domIMP = new DOMImplementation();
        
        $professoresDTD = $domIMP->createDocumentType('professores', '', 'dtd/professores.dtd');
        $domDOC = $domIMP->createDocument('', '', $professoresDTD);
        $domDOC->formatOutput = true;

        $professores = $domDOC->createElement('professores');
        $domDOC->appendChild($professores);

        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $professor = $domDOC->createElement('professor');
            $nome = $domDOC->createElement('nome', $row->nome);
            $email = $domDOC->createElement('email', $row->email);

            $attr = $domDOC->createAttribute('id');
            $attr->value = $row->id;
            
            $professor->appendChild($attr);
            $professores->appendChild($professor);
            $professor->appendChild($nome);
            $professor->appendChild($email);
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

    unset($database,$db,$professor,$sql,$row);
    
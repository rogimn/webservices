<?php
    header("content-type: application/xml; charset=UTF-8");

    // call required files

    include_once 'config/Database.php';
    include_once 'models/Disciplina.php';

    // get database connection

    $database = new Database();
    $db = $database->getConnection();

    $disciplina = new Disciplina($db);
    $sql = $disciplina->readAll();

    if ($sql->rowCount() > 0) {
        $fileXML = 'xml/disciplinas.xml';
        
        $domDOC = new DOMDocument('1.0', 'UTF-8');
        $domIMP = new DOMImplementation();
        
        $disciplinasDTD = $domIMP->createDocumentType('disciplinas', '', 'dtd/disciplinas.dtd');
        $domDOC = $domIMP->createDocument('', '', $disciplinasDTD);
        $domDOC->formatOutput = true;

        $disciplinas = $domDOC->createElement('disciplinas');
        $domDOC->appendChild($disciplinas);

        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $disciplina = $domDOC->createElement('disciplina');
            $codigo = $domDOC->createElement('codigo', $row->codigo);
            $nome = $domDOC->createElement('nome', $row->nome);
            $carga = $domDOC->createElement('carga', $row->carga);
            $ementa = $domDOC->createElement('ementa', $row->ementa);
            $semestre = $domDOC->createElement('semestre', $row->semestre);
            $curso = $domDOC->createElement('curso', $row->curso);

            $attr = $domDOC->createAttribute('id');
            $attr->value = $row->id;
            
            $disciplina->appendChild($attr);
            $disciplinas->appendChild($disciplina);
            $disciplina->appendChild($codigo);
            $disciplina->appendChild($nome);
            $disciplina->appendChild($carga);
            $disciplina->appendChild($ementa);
            $disciplina->appendChild($semestre);
            $disciplina->appendChild($curso);
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

    unset($database,$db,$disciplina,$sql,$row);
    
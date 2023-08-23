<?php
$fileXML = '../xml/bookstore.xml';
$domDOCDOC = new DOMDocument();
$domIMP = new DOMImplementation();

$dtd = $domIMP->createDocumentType('bookstore', '', 'dtd/books.dtd');
$domDOC = $domIMP->createDocument('', '', $dtd);
$domDOC->formatOutput = true;

$bookstore = $domDOC->createElement('bookstore');
$book = $domDOC->createElement('book');
$title = $domDOC->createElement('title', 'XML Book');

$attr = $domDOC->createAttribute('id');
$attr->value = 1;
$book->appendChild($attr);

$domDOC->appendChild($bookstore);
$bookstore->appendChild($book);
$book->appendChild($title);

$domDOC->save($fileXML);
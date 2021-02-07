<?php
require_once 'spout/src/Spout/Autoloader/autoload.php';
// $filePath = 'res/sample.ods';
$filename = time();

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

$writer = WriterEntityFactory::createODSWriter();

// $writer->openToFile($filePath); // write data to a file or to a PHP stream
$writer->openToBrowser($filename); // stream data directly to the browser

$data = ['encrypted' => $_GET['enc'], 'num' => $_GET['num']];
$cells = [
    [
        WriterEntityFactory::createCell("Dalam Bentuk teks"),
        WriterEntityFactory::createCell($data['encrypted'])
    ],
    [
        WriterEntityFactory::createCell("Dalam Bentuk integer"),
        WriterEntityFactory::createCell($data['num'])
    ]
];

/** add a row at a time */
// $singleRow = WriterEntityFactory::createRow($cells);
// $writer->addRow($singleRow);

/** add multiple rows at a time */
$multipleRows = [
    WriterEntityFactory::createRow($cells[0]),
    WriterEntityFactory::createRow($cells[1]),
];
$writer->addRows($multipleRows);

/** Shortcut: add a row from an array of values */
// $values = ['Carl', 'is', 'great!'];
// $rowFromValues = WriterEntityFactory::createRowFromArray($values);
// $writer->addRow($rowFromValues);

$writer->close();

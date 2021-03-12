<?php
require_once 'spout/src/Spout/Autoloader/autoload.php';
require_once 'Crypto.php';
$cryp = new Crypto;

$keyXor = $_POST['keyXOR'];
$keyD = $_POST['keyD'];
$keyN = $_POST['keyN'];

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

date_default_timezone_set('Asia/Jakarta');


/**
 * Membaca File ODS Yang Di Upload dan meng enkripsi isi dari tiap2 cell
 */
$reader = ReaderEntityFactory::createODSReader();
$reader->open($_FILES['ods']['tmp_name']);
$dataFromFile = [];
foreach ($reader->getSheetIterator() as $sheet) {
    if ($sheet->isActive()) {
        foreach ($sheet->getRowIterator() as $row) {
            $dataRow = [];
            foreach ($row->getCells() as $column) {
                $dataRow[] = [
                    'value' => $cryp->decrypt($column->getValue(), $keyXor, $keyD, $keyN),
                    'type' => $column->getType(),
                    'style' =>  $column->getStyle()
                ];
            }
            $dataFromFile[] = $dataRow;
        }
    }
}
$reader->close();


/**
 * Membuat File ods baru yang akan langsung di download oleh user
 * berdasarkan data dari file yang diupload dan telah dienkripsi
 */
$writer = WriterEntityFactory::createODSWriter();
$filename = 'enkripsi-' . date("d-m-Y") . '-' . date("H:i:s") . '.ods';
$writer->openToBrowser($filename);
$rowsData = [];
foreach ($dataFromFile as $data) {
    $dataRow = [];
    foreach ($data as $d) {
        $styleFromFile = $d['style'];
        $style = new StyleBuilder();
        if ($styleFromFile->isFontBold()) {
            $style->setFontBold();
        }
        if ($styleFromFile->isFontItalic()) {
            $style->setFontItalic();
        }
        if ($styleFromFile->isFontUnderline()) {
            $style->setFontItalic();
        }
        $style->setFontSize($styleFromFile->getFontSize())
            ->setFontColor($styleFromFile->getFontColor())
            ->setFontName($styleFromFile->getFontName());
        $dataRow[] = WriterEntityFactory::createCell($d['value'], $style->build());
    }
    $writer->addRow(WriterEntityFactory::createRow($dataRow));
}
$writer->close();

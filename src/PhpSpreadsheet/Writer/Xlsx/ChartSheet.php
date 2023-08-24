<?php

namespace PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as PhpspreadsheetWorksheet;

/**
 * Summary of Chartsheet
 */
class Chartsheet extends Worksheet
{
    /**
     * Write worksheet to XML format.
     *
     * @param string[] $pStringTable
     * @param bool $includeCharts Flag indicating if we should write charts
     *
     * @return string XML Output
     */
    public function writeChartsheet(PhpspreadsheetWorksheet $pSheet, $pStringTable = null, $includeCharts = false)
    {
        // Create XML writer
        $objWriter = null;
        if ($this->getParentWriter()->getUseDiskCaching()) {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
        } else {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);
        }

        // XML header
        $objWriter->startDocument('1.0', 'UTF-8', 'yes');

        // Worksheet
        $objWriter->startElement('chartsheet');
        $objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $objWriter->writeAttribute('xmlns:r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');

        // sheetPr
        $this->writeSheetPr($objWriter, $pSheet);

        // sheetViews
        $this->writeSheetViews($objWriter, $pSheet);

        // Page margins
        $this->writePageMargins($objWriter, $pSheet);

        // Drawings and/or Charts
        $this->writeDrawings($objWriter, $pSheet, $includeCharts);

        $objWriter->endElement();

        // Return
        return $objWriter->getData();
    }
}
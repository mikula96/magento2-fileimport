<?php

namespace SmSoftware\Import\Model\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use SmSoftware\Import\Model\Dto\AdditionalAttributesDTO;
use SmSoftware\Import\Model\Dto\TireDataDTO;

class FileHandler
{
    public function readFileToArray($filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = [];

        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex === 1) {
                // Skip header row
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            $additionalAttributes = [];
            if (isset($rowData[11])) {
                $attributes = explode(',', $rowData[11]);
                $additionalAttributes = new AdditionalAttributesDTO(
                    $attributes[0] ?? '',
                    $attributes[1] ?? '',
                    $attributes[2] ?? ''
                );
            }

            $data[] = new TireDataDTO(
                $rowData[0],
                $rowData[1],
                $rowData[2],
                $rowData[3],
                $rowData[4],
                $rowData[5],
                $rowData[6],
                $rowData[7],
                $rowData[8] ?? null,
                $rowData[9] ?? null,
                $rowData[10] ?? null,
                [$additionalAttributes]
            );
        }

        return $data;
    }
}
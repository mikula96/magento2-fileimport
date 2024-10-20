<?php

namespace SmSoftware\Import\Model;

class ReportGenerator
{
    private function __construct(){}

    public static function generateReport(array $reportData): void
    {
        $filename = 'var/import/import_report_' . date('Y-m-d_H-i-s') . '.csv';
        $file = fopen($filename, 'w');
        fputcsv($file, ['sku', 'status', 'message']);
        foreach ($reportData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}
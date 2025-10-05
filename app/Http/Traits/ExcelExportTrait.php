<?php

namespace App\Http\Traits;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Carbon\Carbon;

trait ExcelExportTrait
{
    /**
     * Export data to Excel (XLSX) or CSV.
     *
     * @param string $fileName
     * @param array $headings
     * @param \Illuminate\Support\Collection $data
     * @param string $format 'xlsx' or 'csv'
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function exportDataToExcel($fileName, array $headings, $data, $format = 'xlsx')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headings
        $sheet->fromArray($headings, null, 'A1');

        // Set data
        $sheet->fromArray($data->toArray(), null, 'A2');

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        if ($format === 'csv') {
            $writer = new Csv($spreadsheet);
            $contentType = 'text/csv';
            $extension = 'csv';
        } else { // Default to xlsx
            $writer = new Xlsx($spreadsheet);
            $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            $extension = 'xlsx';
        }

        $response = response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName . '.' . $extension, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment;filename="' . $fileName . '.' . $extension . '"',
            'Cache-Control' => 'max-age=0',
        ]);

        return $response;
    }
}
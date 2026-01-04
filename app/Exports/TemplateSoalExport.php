<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TemplateSoalExport implements FromArray, WithHeadings, WithStyles, WithEvents
{
    public function headings(): array
    {
        return [
            'Mata Pelajaran', 
            'Tingkat Kelas', 
            'Tipe', 
            'Pertanyaan', 
            'Opsi A', 
            'Opsi B', 
            'Opsi C', 
            'Opsi D', 
            'Opsi E', 
            'Kunci Jawaban', 
            'Poin'
        ];
    }

    public function array(): array
    {
        return [
            ['Matematika', '5', 'pilihan_ganda', 'Berapa hasil dari 2 + 2?', '3', '4', '5', '6', '', 'B', '10'],
            ['IPA', '5', 'essay', 'Jelaskan proses fotosintesis!', '', '', '', '', '', 'Proses tumbuhan...', '20'],
            ['PKN', '5', 'benar_salah', 'Jakarta adalah ibukota Indonesia', '', '', '', '', '', 'benar', '5'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text, with blue background
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']], // Indigo-600
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            // Default styling for all cells
            'A1:K100' => [
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP],
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 100; // Apply validation to first 100 rows

                // Set Column Widths
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(40);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(15);
                $sheet->getColumnDimension('J')->setWidth(20);
                $sheet->getColumnDimension('K')->setWidth(10);

                // Set Row Height for Header
                $sheet->getRowDimension(1)->setRowHeight(30);

                // 1. Dropdown for Tingkat Kelas (Column B)
                $validation = $sheet->getCell('B2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input Error');
                $validation->setError('Pilih tingkat kelas 1-12');
                $validation->setFormula1('"1,2,3,4,5,6,7,8,9,10,11,12"');

                // Apply to B2:B100
                for ($i = 2; $i <= $rowCount; $i++) {
                    $sheet->getCell("B$i")->setDataValidation(clone $validation);
                }

                // 2. Dropdown for Tipe (Column C)
                $validationTipe = $sheet->getCell('C2')->getDataValidation();
                $validationTipe->setType(DataValidation::TYPE_LIST);
                $validationTipe->setErrorStyle(DataValidation::STYLE_STOP);
                $validationTipe->setAllowBlank(false);
                $validationTipe->setShowInputMessage(true);
                $validationTipe->setShowErrorMessage(true);
                $validationTipe->setShowDropDown(true);
                $validationTipe->setErrorTitle('Tipe Soal Invalid');
                $validationTipe->setError('Pilih tipe: pilihan_ganda, essay, atau benar_salah');
                $validationTipe->setFormula1('"pilihan_ganda,essay,benar_salah"');

                // Apply to C2:C100
                for ($i = 2; $i <= $rowCount; $i++) {
                    $sheet->getCell("C$i")->setDataValidation(clone $validationTipe);
                }

                // 3. Dropdown for Kunci Jawaban (Column J) - PARTIAL SOLUTION
                // We provide dropdown for Pilihan Ganda (A-E) & Benar/Salah (benar,salah)
                // For Essay, user can type anything. 
                // Excel validation allows flexible input if we use TYPE_LIST without restrictive ErrorStyle
                
                $validationKunci = $sheet->getCell('J2')->getDataValidation();
                $validationKunci->setType(DataValidation::TYPE_LIST);
                $validationKunci->setErrorStyle(DataValidation::STYLE_INFORMATION); // Information only, doesn't block input
                $validationKunci->setAllowBlank(false);
                $validationKunci->setShowInputMessage(true);
                $validationKunci->setShowErrorMessage(false); // Don't show error, allow free text for Essay
                $validationKunci->setShowDropDown(true);
                $validationKunci->setPromptTitle('Panduan Kunci Jawaban');
                $validationKunci->setPrompt('Pilih A-E untuk PG, benar/salah untuk B/S, atau ketik manual untuk Essay');
                $validationKunci->setFormula1('"A,B,C,D,E,benar,salah"');

                // Apply to J2:J100
                for ($i = 2; $i <= $rowCount; $i++) {
                    $sheet->getCell("J$i")->setDataValidation(clone $validationKunci);
                }
            },
        ];
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class BookingMeetingRoomExport implements WithTitle, WithDrawings, WithHeadings, WithCustomStartCell, WithStyles, FromArray
{
    use Exportable;

    protected $data;

    public function __construct(Collection $dataa)
    {
        $this->data = $dataa;
    }

    public function title(): string
    {
        return 'booking meeting rooms';
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],

        ];
        $sheet->getStyle("A1:J100")->getFont()->setName('Khmer');
        $sheet->getTabColor()->setRGB('0000ff');
        $sheet->getStyle('A5:J5')->getFont()->getColor()->setARGB('FFFFFF');
        $sheet->getStyle("A5:J5")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');
        $sheet->getStyle("A1:J4")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFA500');
        for ($i = 0; $i <= count($this->array()); $i++) {
            $row = $i + 5;
            $sheet->getStyle("A$row:J$row")->getFont()->setSize(9);
            $sheet->getStyle("A$row:J$row")->applyFromArray($styleArray);

            if ($i == count($this->array())) {
                $see = $row + 2;
                $date = $see + 1;
                $locate = $date + 1;
                $last = $locate + 1;

                $sheet->getCell("C$see")->setValue('បានឃើញ និងឯកភាព');

                $sheet->getCell("B$date")->setValue('ថ្ងៃ            ខែ            ឆ្នាំ          ព.ស ២៥');
                $sheet->getCell("G$date")->setValue('ថ្ងៃ            ខែ            ឆ្នាំ          ព.ស ២៥ ');

                $sheet->getCell("B$locate")->setValue('     រាជធានីភ្នំពេញ ថ្ងៃទី         ខែ           ឆ្នាំ ២០');
                $sheet->getCell("G$locate")->setValue('     រាជធានីភ្នំពេញ ថ្ងៃទី         ខែ           ឆ្នាំ​ ២០');

                $sheet->getCell("C$last")->setValue('ការិយាល័យរដ្ឋបាល និងហិរញ្ញវត្ថុ');
                $sheet->getCell("I$last")->setValue('មន្រ្តីទទួលបន្ទុក');
                $sheet->getStyle("A$see:L$last")->getFont()->setSize(9);
            }
        }
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('audit');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/images/logo3.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('B2');

        $drawing2 = new Drawing();
        $drawing2->setName('headofcambodian');
        $drawing2->setDescription('This is a second image');
        $drawing2->setPath(public_path('/assets/images/headofcambodian.png'));
        $drawing2->setHeight(50);
        $drawing2->setCoordinates('H2');

        return [
            $drawing,
            $drawing2
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            [' ', ' ', ' ', 'បញ្ជីការកក់បន្ទប់ប្រជុំរបស់អង្គភាពសវនកម្មនៃ អ.ស.ហ'],
            [
                'ល.រ',
                'កាលបរិច្ឆេទ',
                'ប្រធានបទ',
                'ដឹកនាំដោយ',
                'ឈ្មោះអ្នកកក់',
                'កម្រិតប្រជុំ',
                'សមាជិក',
                'បន្ទប់',
                'ម៉ោង',
                'គោលបំណង',
            ],
        ];
    }

    public function array(): array
    {
        $booking = [];
        foreach ($this->data as $key => $item) {

            $booking[] = [
                $key + 1,
                $item->date,
                $item->topicOfMeeting,
                $item->directedBy,
                $item->name,
                $item->meetingLevel,
                $item->member,
                $item->room,
                $item->time,
                $item->description,
            ];
        }
        return $booking;
    }
}

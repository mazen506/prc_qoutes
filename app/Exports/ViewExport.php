<?php

namespace App\Exports;

use App\Models\Qoute;
use App\Models\QtItem;
use App\Models\Unit;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;



class ViewExport implements FromCollection, WithMapping, WithHeadings,WithCustomStartCell,
                            WithDrawings,WithTitle,WithEvents,WithStyles,ShouldAutoSize
{
    use Exportable;
    protected $qoute;
    protected $items;
    protected $currency;
    protected $vendor;

    public function __construct(int $qoute) 
    {
        $this->qoute = Qoute::find($qoute);
    }

    public function startCell(): string
    {
        return 'B10';
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Styling a specific cell by coordinate.
            '10'    => ['font' => 
                                    ['bold' =>true, 
                                    'name' => 'DroidArabicKufiRegular'], 
                        'background' => ['color' => '#f5f5f5'],
                        'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                       ],
            'C' => [
                        'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
                   ],
            'C2' => ['font' => ['bold' => true], ['size' => 30]],
            'D5' => ['font' => ['bold' => true], ['size' => 30]],
            'C6' => ['font' => ['bold' => true], ['size' => 30], ['alignment' => ['horizontal' => 'right']]],
            'C7' => ['font' => ['bold' => true], ['size' => 30], ['alignment' => ['horizontal' => 'right']]],
            'C8' => ['font' => ['bold' => true], ['size' => 30], ['alignment' => ['horizontal' => 'right']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                //Right To left
                $event->getDelegate()->setRightToLeft(true);
//                $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(50);
                

                //Set Logo Description
                    $event->sheet->setCellValue('C2', $this->vendor['title_' . app()->getLocale() ]); 
                    $event->sheet->mergeCells('C2:F4');

                    $event->sheet->getDelegate()->getStyle('C2')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                    

                //Set sheet caption
                    $event->sheet->mergeCells('D5:H5');
                    $event->sheet->mergeCells('G10:H10');
                    $event->sheet->setCellValue('D5', __('global.qoute')); 
                    $event->sheet->getDelegate()->getStyle('D5')
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //Set Qoute Name
                    $event->sheet->setCellValue('C6', __('global.customer_name') . '/'); 
                    $event->sheet->setCellValue('D6', $this->qoute->name); 

                    $event->sheet->setCellValue('C7', __('global.currency') . '/'); 
                    $event->sheet->setCellValue('D7', $this->currency); 

                    $event->sheet->setCellValue('C8', __('global.note') . '/');
                    $event->sheet->setCellValue('D8', $this->qoute->note); 

                //Set Qoute Details

                // Images

                // Set Header Decoration
                $loop = 0;
                $row_offset = 11;
                ini_set('memory_limit', '512M');
                foreach($this->items as $item)
                {
                    $drawing = new MemoryDrawing();
                    $drawing->setName('الشعار');
                    $drawing->setDescription('مكة للتجارة');

                    if ($item->images == null)
                        continue;

                    $img = explode('|', $item->images)[0];
                    $source = storage-url + '/images/' . $img;
                    $stype = explode('.', $img)[1];
                    switch($stype) {
                        case 'gif':
                        $simg = imagecreatefromgif($source);
                        break;
                        case 'jpg':
                        $simg = imagecreatefromjpeg($source);
                        break;
                        case 'png':
                        $simg = imagecreatefrompng($source);
                        break;
                    }
                    
                    imagesavealpha($simg, true);
                  //  $simg= imagescale ( $simg, 50 , 50);

                    $row_number = $row_offset + $loop;
                    $drawing->setImageResource($simg);
                    $drawing->setResizeProportional(false);
                    $drawing->setWidth(50);
                    $drawing->setHeight(50);
                    $drawing->setCoordinates('C' . $row_number);
                    $drawing->setWorksheet($event->sheet->getDelegate());
                    $event->sheet->getRowDimension($row_number)->setRowHeight(50);

                    //Align
                    $event->sheet->getStyle('B' . $row_number . ':' . 'L' . $row_number)
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    imagedestroy($simg);
                    //Remove Background
                    $loop++;
                }
             },
         ];
    }

    public function headings(): array
    {
        return [
            'التسلسل',
            'الصورة',
            'الإسم',
            'الكمية',
            'الوحدة',
            'العبوة',
            '',
            'السعر',
            'إجمالي السعر',
            'سي بي إم',
            'إجمالي سي بي إم',
            'ملاحظات'
        ];
    }

    public function map($items): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            [   
                $items->serial,
                '',
                $items->item_name,
                $items->qty,
                $items->unit,
                $items->package_qty,
                $items->package_unit,
                $items->price,
                $items->total_price,
                $items->cpm,
                $items->total_cpm,
                $items->note
            ]
        ];
    }

    public function title(): string
    {
    	return 'عرض سعر' . $this->qoute;
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->getDelegate()->setRightToLeft(true);
    //             $event->sheet->setCellValue('A2', $this->$qoute->name); 
    //        },
    //     ];
    // }

    public function drawings()
    {

        $drawing = new MemoryDrawing();
        $drawing->setName('الشعار');
        $drawing->setDescription('مكة للتجارة');
        $drawing->setOffsetX(15);
        $drawing->setOffsetY(15);
        $simg = imagecreatefrompng( $storage_url . '/images/CHTLM0KC5NIhgBb2ZsLuruyzNCUGbz5GLvxDwdTy.png');
        imagesavealpha($simg, true);
        $drawing->setImageResource($simg);
        $drawing->setResizeProportional(false);
        $drawing->setWidth(80);
        $drawing->setHeight(80);
        // $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_PNG);
        // $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
        $drawing->setCoordinates('B1');
        
        return $drawing;
    }
    public function collection()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $items = DB::table('qoutes')
        ->join('qt_items', 'qoutes.id' ,'=' ,'qt_items.qoute_id')
        ->join('currencies as currencies', 'qoutes.currency_id' , '=', 'currencies.id')
        ->join('units as units', 'qt_items.unit_id', '=', 'units.id')
        ->join('units as package_units', 'qt_items.package_unit_id' , '=' , 'package_units.id')
        ->where('qoutes.id', $this->qoute->id)
        ->where('qt_items.qty', '!=', 0)
        ->select(DB::raw('@rownum  := @rownum  + 1 AS serial'),
                'qt_items.images',
                'qt_items.item_name',
                'qt_items.qty',
                'units.name as unit',
                'qt_items.package_qty',
                'package_units.name as package_unit',
                DB::raw('qt_items.price+0 as price'),
                DB::raw('qt_items.qty*qt_items.package_qty*qt_items.price as total_price'),
                DB::raw('qt_items.qty*qt_items.cpm as total_cpm'),
                'qt_items.cpm',
                'qt_items.note'
                )
        ->get();

        $this->items = $items;
        $this->currency = Currency::find($this->qoute->currency_id)['code_' . app()->getLocale()];
        $this->vendor = User::find($this->qoute->user_id);
        return $items;
    }
}

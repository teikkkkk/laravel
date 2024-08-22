<?php

namespace App\Http\Controllers;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductExportController extends Controller
{
    public function export()
    {
        $products = Product::with('colors')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Tên sản phẩm');
        $sheet->setCellValue('B1', 'Màu sắc');
        $sheet->setCellValue('C1', 'còn lại');

        $row = 2; 
        foreach ($products as $product) {
            $colors = $product->colors->pluck('name')->implode(', ');
            $sheet->setCellValue('A' . $row, $product->name);
            $sheet->setCellValue('B' . $row, $colors);
            $sheet->setCellValue('C' . $row, $product->quantity);
            $row++;  
        }
 
        $content = new Csv($spreadsheet);
        $content->setUseBOM(true);
        $filename = 'products.csv'; 
        $content->save(Storage::path($filename));
        return  Storage::download($filename);
    }
}

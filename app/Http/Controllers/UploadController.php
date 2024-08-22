<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
     
        $request->validate([
            'csvfile' => 'required|file|mimes:csv,txt',
        ]);
        $csv=array_map('str_getcsv',file($request->csvfile));
        $header=$csv[0];
        unset($csv[0]);
        foreach ($csv as $key => $value) {
            $record=array_combine($header,$value);
            Product::create($record);
        }
        return redirect()->route('products.index')->with('success', 'upload sản phẩm thành công.');
    }
}

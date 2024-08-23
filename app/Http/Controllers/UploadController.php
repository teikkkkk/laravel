<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $errorMessages = [];
        foreach ($csv as $rowNumber => $value) {
            $record = array_combine($header, $value);
            $validator = Validator::make($record, [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'entry_date' => 'nullable|date',
                'category_id' => 'required|integer|exists:categories,id',
                'quantity' => 'required|integer|min:0',
                'status' => 'required|in:available,unavailable',
                'image' => 'nullable|string',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errorMessages[] = "Dòng " . ($rowNumber + 1) . ", cột '{$field}': {$message}";
                    }
                }
                continue;
            }

            Product::create($record);
        }

        if (!empty($errorMessages)) {
            return redirect()->back()->withErrors($errorMessages);
        }
        return redirect()->back()->with('success', 'upload sản phẩm thành công.');
    }
}

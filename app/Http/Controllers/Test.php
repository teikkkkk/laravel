<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class Test extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            'csvfile'=>'required|file'
        ]);
        $csv=array_map('str_getcsv',file($request->cvsfile));
        $header=$csv[0];
        unset($csv[0]);
        $errorMessages=[];
        foreach($csv as $row => $value) {
            $record=array_combine($header,$value);
            $validator=Validator::make($record,[
                'name'=>'required|string',
                'price'=>'required|numeric|min:0',
                'entry_date'=>'required|date',
                'category_id'=>'required|integer',
                'quantity'=>'required|integer',
               'status'=>'required|in:available,unavailable',
               'image'=>'nullable|string',
               'description'=>'nullable|string'
            ]);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errorMessages[]='dòng'.($row+1).", cột '{$field}' :{$message}";
                    }
                }
                continue;
            }
            Product::create($record);
        }
       if (!empty($errorMessages)) {
    return redirect()->back()->withErrors($errorMessages);
       }
       return redirect()->back()->with('success','upload thành công');
    }

}


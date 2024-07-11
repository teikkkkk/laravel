<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product; // Import model Product

class ProductController extends Controller
{
   
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create');
    }
  

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'entry_date' => 'required|date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            'quantity'=>'numeric',
            'type'=>'string',
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $imagePath = str_replace('public/', '', $imagePath); 
        } else {
            $imagePath = null; 
        }

        $product = new Product([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'entry_date' => $request->get('entry_date'),
            'image' => $imagePath,
            'quantity'=>$request->get('quantity'),
            'type'=>$request->get('type'),

        ]);
    
        $product->save();
    
        return redirect()->route('products.index')
                         ->with('success', 'Sản phẩm đã được thêm thành công.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'entry_date' => 'nullable|date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            'quantity'=>'string',
            'type'=>''
        ]);
    
        $product = Product::findOrFail($id);
    
        // Lưu trữ ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
    
            // Lưu trữ ảnh mới
            $imagePath = $request->file('image')->store('public/images');
            $imagePath = str_replace('public/', '', $imagePath); // Chỉ lưu đường dẫn từ thư mục public trở đi
        } else {
            $imagePath = $product->image; // Giữ nguyên ảnh cũ nếu không có ảnh mới
        }
    
        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'entry_date' => $request->get('entry_date'),
            'image' => $imagePath,
            'quantity'=>$request->get('quantity'),
            'type'=>$request->get('type'),
            
        ]);
    
        return redirect()->route('products.index')
                         ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Danh mục đã được xoá thành công.');
    }

    public function productsByType($type)
    {
        // Lấy danh sách sản phẩm theo type
        $products = Product::where('type', $type)->get();

        // Trả về view hiển thị danh sách sản phẩm theo loại
        return view('products.by_type', compact('products', 'type'));
    }
    public function search(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
    
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
    
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
        $products = $query->get();
    
        return view('products.search', compact('products'));
    }
}

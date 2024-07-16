<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12); 
        $categories = Category::all(); 

        return view('products.index', compact('products', 'categories')) ->with('products', $products->withPath('custom'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'entry_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'quantity' => 'numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'quantity' => $request->get('quantity'),
            'category_id' => $request->get('category_id'),  
            'description' => $request->get('description'),
        ]);

        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = new ProductImage();
                $image->image_path = $file->store('product_images');
                $image->product_id = $product->id;
                $image->save();
            }
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'entry_date' => 'nullable|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'quantity' => 'string',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $imagePath = $request->file('image')->store('public/images');
            $imagePath = str_replace('public/', '', $imagePath); 
        } else {
            $imagePath = $product->image;  
        }

        $product->update([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'entry_date' => $request->get('entry_date'),
            'image' => $imagePath,
            'quantity' => $request->get('quantity'),
            'category_id' => $request->get('category_id'),
            'description' => $request->get('description'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = new ProductImage();
                $image->image_path = $file->store('product_images');
                $image->product_id = $product->id;
                $image->save();
            }
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Danh mục đã được xoá thành công.');
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->get();
        $categories = Category::all();

        return view('products.search', compact('products', 'categories'));
    }

    public function productsByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        $categories = Category::all();
        return view('products.by_type', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    public function purchase(Request $request, $id)
        {
            $product = Product::findOrFail($id);
            return view('products.info_client', compact('product'));
        }

    public function complete( $id)
        {
           
            $product = Product::findOrFail($id);
             return redirect()->route('products.index')->with('success', 'Đơn hàng của bạn đã được xác nhận!');
        }

}

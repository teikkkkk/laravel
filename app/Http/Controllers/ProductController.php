<?php
namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{ 
    public function index(Request $request)
    {
        $products = Product::paginate(12); 
        $categories = Category::all(); 

        return view('products.index', compact('products', 'categories')) ->with('products', $products->withPath('custom'));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = Color::all(); 
        return view('products.create', compact('categories','colors'));
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
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
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
    
      
        if ($request->has('colors')) {
            $colors = $request->input('colors');
            $product->colors()->sync($colors);
        }
    
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công.');
    }
    
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'entry_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
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
    
        $product->colors()->sync($request->get('colors', []));
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = new ProductImage();
                $image->image_path = $file->store('public/images');
                $image->image_path = str_replace('public/', '', $image->image_path); 
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
        $colors = Color::all();  
        $selectedColors = $product->colors->pluck('id')->toArray();  
        $images = $product->images()->get(); 
        return view('products.edit', compact('product', 'categories', 'colors', 'selectedColors','images'));
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
        $products = Product::where('category_id', $category_id)
            ->with('reviews')  
            ->get();

        $products = $products->map(function ($product) {
            $product->review_count = $product->reviews->count();

            $product->average_rating = $product->reviews->avg('rating');
    
            return $product;
        });

        $categories = Category::all();
        return view('products.by_type', compact('products', 'categories'));
    }
    

    public function show($id)
    {
        $product = Product::with('images','reviews')->findOrFail($id);

        $images = $product->images;
        $sizes = Size::where('category_id', $product->category_id)->get();
        $reviewCount = $product->reviews->count();
        $averageRating = $product->reviews->avg('rating');
        return view('products.show', compact('product', 'images', 'sizes','averageRating','reviewCount'));
    }
    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cartItems = CartItem::all(); 
        $totalCartPrice = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        $quantity = $request->input('quantity', 1); 
        return view('products.info_client', compact('product', 'cartItems', 'totalCartPrice','quantity'));
    }
        public function completePurchase(Request $request, $id)
        {
            $product = Product::findOrFail($id);
            $request->validate([
                'quantity' => 'required|integer|min:1',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
            ]);
       
      
            return redirect()->route('products.index')->with('success', 'Đơn hàng của bạn đã được xác nhận!');
        }
      
    public function filterStatistics(Request $request)
        {
                $query = OrderItem::query();
        
                // Lọc theo khoảng thời gian
                if ($request->has('start_date') && $request->start_date != '') {
                    $query->where('created_at', '>=', $request->start_date);
                }
        
                if ($request->has('end_date') && $request->end_date != '') {
                    $query->where('created_at', '<=', $request->end_date);
                }
          
                if ($request->has('category_id') && $request->category_id != '') {
                    $query->whereHas('product', function ($q) use ($request) {
                        $q->where('category_id', $request->category_id);
                    });
                }
         
                if ($request->has('product_name') && $request->product_name != '') {
                    $query->whereHas('product', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->product_name . '%');
                    });
                }
         
                $orderItems = $query->select('product_id')
                    ->selectRaw('SUM(quantity) as total_quantity')
                    ->selectRaw('SUM(unit_price * quantity) as total_price')
                    ->selectRaw('MAX(created_at) as latest_date')
                    ->groupBy('product_id');
        
                // Lọc theo số lượng bán  
                if ($request->has('sales_filter') && $request->sales_filter == 'most_sold') {
                    $orderItems->orderBy('total_quantity', 'desc');
                } elseif ($request->has('sales_filter') && $request->sales_filter == 'least_sold') {
                    $orderItems->orderBy('total_quantity', 'asc');
                }
        
                // Sắp xếp doanh thu 
                if ($request->has('sort') && $request->sort == 'desc') {
                    $orderItems->orderBy('total_price', 'desc');
                } elseif ($request->has('sort') && $request->sort == 'asc') {
                    $orderItems->orderBy('total_price', 'asc');
                }
        
                
                $orderItems = $orderItems->with('product')->paginate(1000);
                $totalSold = $orderItems->sum('total_quantity');
                $categories = Category::all();
        
                return view('products.statistics', compact('categories', 'totalSold', 'orderItems'))
                    ->with('start_date', $request->start_date)
                    ->with('end_date', $request->end_date)
                    ->with('category_id', $request->category_id)
                    ->with('product_name', $request->product_name)
                    ->with('sales_filter', $request->sales_filter)
                    ->with('sort', $request->sort);
        }
    public function addReview(Request $request, $id)
        {
                $request->validate([
                    'rating' => 'required|integer|min:1|max:5',
                    'content' => 'required|string',
                ]);
            
                $review = new Review();
                $review->product_id = $id;
                $review->rating = $request->rating;
                $review->content = $request->content;
                $review->name=Auth::user()->name;
                $review->save();
            
                return response()->json(['message' => 'đánh giá được lưu', 'review' => $review]);
        }
        public function updateReview(Request $request, $productId, $reviewId)
        {
         
                $request->validate([
                    'rating' => 'required|integer|min:1|max:5',
                    'content' => 'required|string',
                ]);
                
                $review = Review::where('id', $reviewId)->where('product_id', $productId)->firstOrFail();
                $review->rating = $request->input('rating');
                $review->content = $request->input('content');
                $review->save();
                return response()->json(['message' => 'Đánh giá đã được cập nhật', 'review' => $review]);
            }
}
<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Events\NewOrderPlaced;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        
        $cartItems = CartItem::with(['product', 'size'])->get();
           
        $total = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

  
    public function add(Request $request, $id)
    {
         
        $product = Product::findOrFail($id);
        $sizeId = $request->input('size');  
 
        $cartItem = CartItem::where('product_id', $product->id)
                            ->where('size_id', $sizeId)
                            ->first();

        if ($cartItem) {
            
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            
            CartItem::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'size_id' => $sizeId,  
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    public function remove($id)
    {
        $cartItem = CartItem::where('product_id', $id)->first();
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Số lượng sản phẩm đã được cập nhật!');
    }

    public function purchaseForm()
    {
        $cartItems = CartItem::with(['product', 'size'])->get();
        return view('cart.purchase', compact('cartItems'));
    }

    public function completePurchase(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $cartItems = CartItem::with(['product', 'size'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống!');
        }

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        $order = Order::create([
            'customer_name' => $request->name,
            'customer_address' => $request->address,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->product->price,
                'size_id' => $cartItem->size_id,
            ]);

            $product = Product::findOrFail($cartItem->product_id);
            $product->quantity -= $cartItem->quantity;
            $product->save();
        }

        CartItem::truncate();
        event(new NewOrderPlaced($order));
        return redirect()->route('home')->with('success', 'Mua hàng thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Add To Cart
     *
     * @param CartRequest $request
     */
    public function addToCart(CartRequest $request)
    {
        $requestData = $request->validated();

        foreach($requestData['product_id'] as $key => $product_id) {
            $product = Product::find($product_id);
            $quantity = 1;

            if ($product->quantity < $quantity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product quantity is less than that of the quantity purchased.'
                ]);
            }

            $cart = Cart::where('product_id', $product_id)->first();

            if ($cart) {
                $cart->increment('quantity', $quantity);
                $total = $product->price * $cart->quantity;
                $cart->update([
                    'quantity' => $cart->quantity,
                    'total' => $total,
                ]);
            } else {
                $total = $product->price * $quantity;

                $data = [
                    'user_id' => auth()->user()->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'total' => $total
                ];

                Cart::create($data);
            }

            $product->decrement('quantity', $quantity);
            $product->update([
                'quantity' => $product->quantity
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart'
        ], 201);
    }

    /**
     * Check out order
     */
    public function checkout()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        foreach ($carts as $cart) {
            $data = [
                'user_id' => $cart->user_id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'total' => $cart->total,
                'status' => 'paid'
            ];

            Order::create($data);

            $cart->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Order checkout successfully.'
        ], 201);
    }

    /**
     * Get all Orders
     */
    public function orders()
    {
        $orders = Order::paginate(10);

        return response()->json([
            'status' => true,
            'orders' => $orders
        ], 200);
    }

    /**
     * Change order status
     *
     * @param Request $request
     */
    public function changeOrderStatus(Request $request, Order $order)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order status successfully updated.',
            'order' => $order
        ], 200);
    }
}

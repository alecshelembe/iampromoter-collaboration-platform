<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialPost;
use Illuminate\Support\Facades\Session; // Import the Session facade

class CartController extends Controller
{
     // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
         $this->middleware('auth');
    }
    /**
     * Adds a social post to the shopping cart.
     *
     * @param int $id The ID of the social post to add to the cart.
     * @param \Illuminate\Http\Request $request The current HTTP request instance.
     * @return \Illuminate\Http\JsonResponse
     */
    public function removefromcart(Request $request, $idToRemove) // Change here: $idToRemove is now a route parameter
    {
        // No need for $idToRemove = $request->input('id'); anymore, it's already available

        if (is_null($idToRemove)) {
            // This check is technically less likely to be hit now if the route is defined correctly,
            // but can still be useful for defensive programming.
            return response()->json([
                'status' => 'error',
                'message' => 'Item ID is required for removal.'
            ], 400); // Bad Request
        }

        try {
            $cart = Session::get('cart', []);
            $initialCartCount = count($cart);

            $cart = array_values(array_filter($cart, function($itemId) use ($idToRemove) {
                return $itemId != $idToRemove;
            }));

            Session::put('cart', $cart);

            if (count($cart) < $initialCartCount) {
                \Log::info("Item with ID {$idToRemove} removed from cart. Current cart: ", $cart);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item removed from cart successfully!',
                    'cart_count' => count($cart)
                ]);
            } else {
                \Log::info("Item with ID {$idToRemove} was not found in cart.");
                return response()->json([
                    'status' => 'info',
                    'message' => 'Item not found in cart.',
                    'cart_count' => count($cart)
                ]);
            }

        } catch (\Exception $e) {
            \Log::error("Error removing item from cart: " . $e->getMessage(), ['id' => $idToRemove]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove item from cart. Please try again later.'
            ], 500);
        }
    }


    public function addtocart($id, Request $request)
    {
        // For demonstration, we'll use a simple session-based cart.
        // In a real application, you might use a database, a dedicated cart package,
        // or more complex session management (e.g., storing quantities, product details).

        try {
            // Get the current cart from the session, or initialize as an empty array if not present.
            // A simple array of IDs for now.
            $cart = Session::get('cart', []);

            // Check if the item is already in the cart to avoid duplicates
            if (!in_array($id, $cart)) {
                $cart[] = $id; // Add the post ID to the cart array
                Session::put('cart', $cart); // Store the updated cart back in the session

                // Log for debugging (optional)
                \Log::info("Item with ID {$id} added to cart. Current cart: ", $cart);

                // Return a success JSON response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item added to cart successfully!',
                    'cart_count' => count($cart) // Optionally send back cart count
                ]);
            } else {
                // Item is already in the cart
                \Log::info("Item with ID {$id} is already in the cart.");
                return response()->json([
                    'status' => 'info',
                    'message' => 'Item is already in your cart.',
                    'cart_count' => count($cart)
                ]);
            }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error("Error adding item to cart: " . $e->getMessage(), ['id' => $id]);

            // Return an error JSON response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add item to cart. Please try again later.'
            ], 500); // 500 Internal Server Error status code
        }
    }

    /**
     * Optional: A method to view the current cart contents (for testing/debugging).
     * This is not directly related to the AJAX request, but useful for a cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
        public function viewCart()
    {
        $cartIds = Session::get('cart', []);

        $results = SocialPost::whereIn('id', $cartIds)->get();

        return view('layouts.checkout', compact('results'));

       
    }

}
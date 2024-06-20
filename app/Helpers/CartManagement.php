<?php
	
	namespace App\Helpers;
	
	use App\Models\Product;
	use Illuminate\Support\Facades\Cookie;
	
	class CartManagement
	{
		// add item to cart
		static public function addItemToCart($product_id) : int
		{
			$cart_items    = self::getCartItemsFromCookie();
			$existing_item = null;
			
			foreach ($cart_items as $key => $item) {
				if ($item['product_id'] == $product_id) {
					$existing_item = $key;
					break;
				}
			}
			
			if ($existing_item !== null) {
				$cart_items[$existing_item]['quantity']++;
				$cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
			}
			else {
				$product = Product::findOrFail($product_id);
				if ($product) {
					
					if (($product->images != null)) {
						$product_image = $product->images[0];
					}
					else {
						$product_image = 'default.jpg';
					}
					$cart_items[] = [
						'product_id'   => $product->id,
						'name'         => $product->name,
						'image'        => $product_image,
						'quantity'     => 1,
						'unit_amount'  => $product->price,
						'total_amount' => $product->price,
					];
				}
			}
			self::addCartItemToCookie($cart_items);
			return count($cart_items);
		}
		
		// remove item from cart
		static public function removeItemFromCart($product_id) : array
		{
			$cart_items = self::getCartItemsFromCookie();
			
			foreach ($cart_items as $key => $item) {
				if ($item['product_id'] == $product_id) {
					unset($cart_items[$key]);
				}
			}
			
			self::addCartItemToCookie($cart_items);
			
			return $cart_items;
		}
		
		// add cart item to cookie
		static public function addCartItemToCookie($cart_items) : void
		{
			Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
		}
		
		// clean cart item from cookie
		static public function clearCartItems() : void
		{
			Cookie::queue(Cookie::forget('cart_items'));
		}
		
		// get all cart item from cookie
		static public function getCartItemsFromCookie() : false|array|string
		{
			$cart_items = json_decode(Cookie::get('cart_items'), true);
			if (!$cart_items) {
				$cart_items = [];
			}
			return $cart_items;
		}
		
		// increment quantity
		static public function incrementQuantityToCartItem($product_id) : false|array|string
		{
			$cart_items = self::getCartItemsFromCookie();
			foreach ($cart_items as $key => $item) {
				if ($item['product_id'] == $product_id) {
					$cart_items[$key]['quantity']++;
					$cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
				}
			}
			
			self::addCartItemToCookie($cart_items);
			return $cart_items;
		}
		
		// decrement quantity
		static public function decrementQuantityToCartItem($product_id) : false|array|string
		{
			$cart_items = self::getCartItemsFromCookie();
			foreach ($cart_items as $key => $item) {
				if ($item['product_id'] == $product_id) {
					$cart_items[$key]['quantity']--;
					$cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
				}
			}
			
			self::addCartItemToCookie($cart_items);
			return $cart_items;
		}
		
		// calculate grand total
		static public function calculateGranTotal($item) : float|int
		{
			return array_sum(array_column($item, 'total_amount'));
		}
	}
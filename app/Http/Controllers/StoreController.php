<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
class StoreController extends Controller {
    public function home() {
        $categories = Category::orderBy('priority')->orderBy('name')->get();
        $featured = Product::with('category')->where('featured',true)->latest()->take(18)->get();

        if ($featured->isEmpty()) {
            $featured = Product::with('category')->latest()->take(18)->get();
        }

        return view('store.home', compact('featured', 'categories'));
    }

    public function shop(Request $request) {
        $categories = Category::orderBy('priority')->orderBy('name')->get();
        $products = Product::with('category')
            ->when($request->filled('q'), fn($q) => $q->where(fn($x) => $x
                ->where('title','like','%'.$request->q.'%')
                ->orWhere('brand','like','%'.$request->q.'%')
                ->orWhere('description','like','%'.$request->q.'%')))
            ->when($request->filled('category'), fn($q) => $q->whereHas('category', fn($x) => $x->where('slug', $request->category)))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('store.shop', compact('products', 'categories'));
    }

    public function product(Product $product) {
        $product->load('category');
        return view('store.product', compact('product'));
    }
}

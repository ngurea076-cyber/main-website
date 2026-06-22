<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
class StoreController extends Controller {
    public function home() { return view('store.home', ['featured'=>Product::with('category')->where('featured',true)->latest()->take(12)->get(), 'categories'=>Category::orderBy('priority')->get()]); }
    public function shop(Request $request) {
        $products=Product::with('category')->when($request->filled('q'),fn($q)=>$q->where(fn($x)=>$x->where('title','like','%'.$request->q.'%')->orWhere('brand','like','%'.$request->q.'%')))
            ->when($request->filled('category'),fn($q)=>$q->whereHas('category',fn($x)=>$x->where('slug',$request->category)))->latest()->paginate(24)->withQueryString();
        return view('store.shop',compact('products'));
    }
    public function product(Product $product) { return view('store.product',compact('product')); }
}

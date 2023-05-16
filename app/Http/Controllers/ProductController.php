<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    //Show All Products
    public function index(){
        return view('products.index', [
        'products' => Product::latest()->filter
        (request(['tag', 'search']))->paginate(6)
    ]);
    }

    //Show Single Product
    public function show(Product $product){
        return view('products.show', [
        'product' => $product
    ]);
    }

    //Show Create Form
    public function create() {
        return view('products.create');
    }

    //Store Product Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('products', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Product::create($formFields);

        return redirect('/')->with('message', 'Product created successfully!');
    }

    // Show Edit Form
    public function edit(Product $product) {
        return view('products.edit', ['product' => $product]);
    }

    //Update Product Data
    public function update(Request $request, Product $product) {

        // Make sure logged in user is owner
        if($product->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $product->update($formFields);

        return back()->with('message', 'Product updated successfully!');
    }

    // Delete Product
    public function destroy(Product $product) {

        if($product->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        if($product->logo && Storage::disk('public')->exists($product->logo)) {
            Storage::disk('public')->delete($product->logo);
        }
        $product->delete();
        return redirect('/')->with('message', 'Product deleted successfully');
    }

    // Manage Products
    public function manage() {
        return view('products.manage', ['products' => auth()->user()->products()->get()]);
    }

}

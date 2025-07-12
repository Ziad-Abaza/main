<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_products']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->paginate(20);
            return view('dashboard.products.index', compact('products'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch products');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();

                        // Set default values
            $validated['is_active'] = $request->has('is_active');

            // Process attributes
            if ($request->has('attributes') && is_array($request->attributes)) {
                $attributes = [];
                foreach ($request->attributes as $attr) {
                    if (!empty($attr['key']) && !empty($attr['value'])) {
                        $attributes[$attr['key']] = $attr['value'];
                    }
                }
                $validated['attributes'] = $attributes;
            }

            $product = Product::create($validated);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection('product_images');
                }
            }

            // Handle product file
            if ($request->hasFile('product_file')) {
                $product->setProductFile($request->file('product_file'));
            }

            return redirect()->route('console.products.index')->with('success', 'Product created successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to create product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            $images = $product->getImages();
            return view('dashboard.products.show', compact('product', 'images'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to display product');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        try {
            $images = $product->getImages();
            return view('dashboard.products.edit', compact('product', 'images'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load product for editing');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            // Set default values
            $validated['is_active'] = $request->has('is_active');

            // Process attributes
            if ($request->has('attributes') && is_array($request->attributes)) {
                $attributes = [];
                foreach ($request->attributes as $attr) {
                    if (!empty($attr['key']) && !empty($attr['value'])) {
                        $attributes[$attr['key']] = $attr['value'];
                    }
                }
                $validated['attributes'] = $attributes;
            }

            $product->update($validated);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection('product_images');
                }
            }

            // Handle product file
            if ($request->hasFile('product_file')) {
                $product->setProductFile($request->file('product_file'));
            }

            return redirect()->route('console.products.index')->with('success', 'Product updated successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to update product');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update product');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Clear all media collections
            $product->clearMediaCollection('product_images');
            $product->clearMediaCollection('product_files');

            $product->delete();

            return redirect()->route('console.products.index')->with('success', 'Product deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete product');
        }
    }

    /**
     * Remove a specific image from the product.
     */
    public function removeImage(Request $request, Product $product)
    {
        try {
            $mediaId = $request->input('media_id');
            $media = $product->getMedia('product_images')->find($mediaId);

            if ($media) {
                $media->delete();
                return response()->json(['success' => true, 'message' => 'Image removed successfully']);
            }

            return response()->json(['success' => false, 'message' => 'Image not found'], 404);
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to remove image'], 500);
        }
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);

            $status = $product->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Product {$status} successfully");
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update product status');
        }
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('dashboard.products.index', compact('products', 'query'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to search products');
        }
    }
}

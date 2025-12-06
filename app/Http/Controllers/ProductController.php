<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // === ПУБЛІЧНІ МЕТОДИ (ДЛЯ КЛІЄНТІВ) ===

    // Головна сторінка каталогу
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Пошук
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Фільтрація за категоріями
        if ($request->has('category') && !empty($request->category)) {
            $query->whereIn('category_id', (array)$request->category);
        }
        
        // Фільтрація за ціною
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Сортування
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc': $query->orderBy('price', 'asc'); break;
                case 'price_desc': $query->orderBy('price', 'desc'); break;
                case 'newest': $query->orderBy('created_at', 'desc'); break;
                default: $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $page = $request->get('page', 1);
        $perPage = ($page == 1) ? 12 : 12;
        
        $products = $query->paginate($perPage, ['*'], 'page', $page);
        $categories = Category::all();
        
        return view('index', compact('products', 'categories'));
    }

    // Сторінка акцій
    public function offers()
    {
        $products = Product::where('discount', '>', 0)
                           ->with('category')
                           ->latest()
                           ->paginate(12);
        return view('offers', compact('products'));
    }

    // --- ПЕРЕГЛЯД ТОВАРУ + СХОЖІ ТОВАРИ ---
    public function show(Product $product)
    {
        // Завантажуємо категорію та відгуки (з авторами)
        $product->load(['category', 'reviews.user']);

        // Знаходимо схожі товари з тієї ж категорії
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Виключаємо поточний товар
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    // --- ЗБЕРЕЖЕННЯ ВІДГУКУ ---
    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Дякуємо за ваш відгук!');
    }


    // === АДМІН МЕТОДИ ===

    public function adminIndex()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'discount' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        Product::create($validated);

        return redirect()->route('admin.index')->with('success', 'Товар успішно додано!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'discount' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        $product->update($validated);

        return redirect()->route('admin.index')->with('success', 'Товар успішно оновлено!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.index')->with('success', 'Товар успішно видалено!');
    }
}
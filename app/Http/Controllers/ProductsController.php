<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Whishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index(Request $request)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');
    $page = $request->input('page', 1);
    $status = $request->input('status');
    $category = $request->input('category');

    $query = Products::where('status', 'available')
        ->where('stock', '>', 0);


    $user = null;
    $token = $request->bearerToken();

    if ($token) {
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user = $accessToken->tokenable; 
        }
    }


    if ($search) {
        $query->where(function($q) use ($search) {
            $searchLower = strtolower($search);
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"])
              ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchLower}%"]);
        });
    }

 
    if ($status) {
        if (is_array($status)) {
            $query->whereIn('status', $status);
        } elseif (is_string($status)) {
            $statusArray = explode(',', $status);
            $query->whereIn('status', $statusArray);
        }
    }
    if ($category) {
        if (is_array($category)) {
            $query->whereIn('category', $category);
        } elseif (is_string($category)) {
            $categoryArray = explode(',', $category);
            $query->whereIn('category', $categoryArray);
        }
    }


    $products = $query->orderBy('created_at', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);


    $products->through(function ($item) use ($user) {
        $isWishlisted = false;

        if ($user) {
            $isWishlisted = Whishlist::where('user_id', $user->id)
                ->where('product_id', $item->id)
                ->exists();
        }

        return [
            ...$item->toArray(),
            'thumbnail_image' => $item->thumbnail_image ? url($item->thumbnail_image) : null,
            'main_image' => $item->main_image ? url($item->main_image) : null,
            'is_whislisted' => $isWishlisted,
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Products retrieved successfully',
        'data' => $products->items() ?? [],
        'meta' => [
            'filters' => [
                'search' => $search ?? '',
                'status' => $status ?? [],
            ],
            'pagination' => [
                'total' => $products->total(),
                'currentPage' => $products->currentPage(),
                'perPage' => $products->perPage(),
                'lastPage' => $products->lastPage(),
                     'hasMore' => $products->currentPage() < $products->lastPage(),
            ],
        ],
    ], 200);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}

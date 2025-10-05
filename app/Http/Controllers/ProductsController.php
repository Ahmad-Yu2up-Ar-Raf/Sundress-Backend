<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Whishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    $token = $request->bearerToken();
        $status = $request->input('status');
        $query = Products::where('status' , 'available')->where('stock' ,'>', 0);

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
            } else if (is_string($status)) {
                $statusArray = explode(',', $status);
                $query->whereIn('status', $statusArray);
            }
        }


       $products = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
    $products->through(function($item) use ($token)  {
            return [
 
         ...$item->toArray(),
           'user_idssd' => Auth::id(), 
                'thumnail_image' => $item->thumnail_image ? url($item->thumnail_image) : null,
                'main_image' => $item->main_image ? url($item->main_image) : null
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
        ]
    ]
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

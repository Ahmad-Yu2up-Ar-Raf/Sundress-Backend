<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhishlistStore;
use App\Models\Whishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class WhishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(WhishlistStore $request)
    {  
              
       Whishlist::create([
                ...$request->validated(),
                 'user_id' => Auth::id(),
            ]);

         

               return response()->json(['message' => 'Whistlist added successfully'], 201); // 201 Created status
    }


    public function unwhislited(Request $request)
    {  
              

    $user = null;
    $token = $request->bearerToken();
    $product_id = $request->get('product_id');

    if ($token) {
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $user = $accessToken->tokenable; 
        }
    } else{
        return response()->json(['message' => 'Not authenthicated'], 201); // 201 Created status
    }
    
    if($user){
        $whishlist = Whishlist::where('user_id' , $user->id)->where('product_id', $product_id);
              
   
              $whishlist->delete();
        
    }



      

               return response()->json(['message' => 'Whistlist added successfully'], 201); // 201 Created status
    }
    public function removeFromWhistlist(WhishlistStore $request)
    {  
              
       Whishlist::create([
                ...$request->validated(),
                 'user_id' => Auth::id(),
            ]);

         

               return response()->json(['message' => 'Whistlist added successfully'], 201); // 201 Created status
    }
   






    /**
     * Display the specified resource.
     */
    public function show(Whishlist $whishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Whishlist $whishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Whishlist $whishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Whishlist $whishlist)
    {
        //
    }
}

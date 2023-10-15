<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $page = $request->query('page', 1);

        
        $perPage = 10;

        
        $products = Product::paginate($perPage, ['*'], 'page', $page);


        return response()->json([
            'products' => $products
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductStoreRequest $request)
    {
        

        $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();

        
        $product = Product::create([
            'name'=>$request->name,
            'image'=>$imageName,
            'description'=>$request->description,
            'user_id'=>$request->user()->id
        ]);


        Storage::disk('public')->put($imageName,file_get_contents($request->image));
        $product->load('user');


        return response()->json([
                'message'=>'Product assigned to user successfully!',
                'data'=>$product
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try
        {
            $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();


            $product =Product::create([
                'name'=>$request->name,
                'image'=>$imageName,
                'description'=>$request->description
            ]);


            Storage::disk('public')->put($imageName,file_get_contents($request->image));

            return response()->json([
                'message'=>'Product added successfully!',
                'data'=>$product
            ],200);


        }
        catch(Exception $e)
        {
            Log::error($e);

            return response()->json([
                'message' => $e->getMessage(),
            ],500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try
        {
            $product = Product::find($id);
            if(!$product)
            {
                return response()->json([
                'message' => 'Product not found',
                ],404);
                
            }

            $product->name = $request->name;
            $product->description = $request->description;
     
            if($request->image) 
            {
                
                $storage = Storage::disk('public');
     
                
                if($storage->exists($product->image))
                {
                    $storage->delete($product->image);//deleting previous old image 

                }
                 
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $product->image = $imageName;
     
                
                $storage->put($imageName, file_get_contents($request->image));

            }
     
            
            $product->save();
     
            
            return response()->json([
                'message' => "Product successfully updated."
            ],200);

        }
        catch(\Exception $e)
        {
            Log::error($e);

            return response()->json([
                'message' => $e->getMessage(),
            ],500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if(!$product){
          return response()->json([
             'message'=>'Product Not Found.'
          ],404);
        }
     
        
        $storage = Storage::disk('public');
     
        
        if($storage->exists($product->image))
        {
            $storage->delete($product->image);

        }
            
     
        
        $product->delete();
     
        
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }



    public function list(Request $request)
    {
        try
        {
            
            $perPage = $request->input('per_page', 10);

        
            $products = Product::with(['user'])->paginate($perPage);

            return response()->json([
                'message' => "User's products successfully fetched.",
                'data' => $products
            ], 200);

        }
        catch(Exception $e)
        {
            Log::error($e);

            return response()->json([
                'message' => $e->getMessage(),
            ],500);

        }


    }
}

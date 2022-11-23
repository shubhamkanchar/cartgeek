<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->id) {
            $data = Product::where('id', $request->id)->update([
                'product_name' => $request->name,
                'product_description' => $request->description,
                'product_price' => $request->price,
            ]);

            $res = [
                'flag' => 1,
                'msg' => 'Product Updated'
            ];
        } else {
            $data = Product::create([
                'product_name' => $request->name,
                'product_description' => $request->description,
                'product_price' => $request->price,
            ]);

            $res = [
                'flag' => 1,
                'msg' => 'Product created'
            ];
        }

        if ($data) {
            if ($request->file('file')) {
                foreach ($request->file('file') as $file) {
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $fileName = str_replace(' ', '_', $fileName);

                    $path = public_path('uploads');
                    $file->move($path, $fileName);
                    $file_name = $fileName;
                    image::create([
                        'product_id' => !empty($request->id) ? $request->id : $data->id,
                        'image' => $file_name
                    ]);
                }
            }
            return response()->json($res);
        } else {
            return response()->json([
                'flag' => 0,
                'msg' => 'something went wrong'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = product::all();
        return view('table', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = product::find($request->id);
        $image = $data->image;
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = product::find($request->id);
        $image = $data->image;
    
        $data = product::where('id',$request->id)->delete();
        if($data){
            return response()->json([
                'flag' => 1,
                'msg' => 'Product deleted'
            ]);
        }else{
            return response()->json([
                'flag' => 0,
                'msg' => 'something went wrong'
            ]);
        }
    }
}

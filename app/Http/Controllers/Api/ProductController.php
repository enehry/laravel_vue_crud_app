<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->where('product_name', 'LIKE',  "%" . $request->q . "%")
            ->whereNull('products.deleted_at')
            ->paginate(10, ['products.*', 'category_name', 'suppliers.name']);
        //
        return response()->json([
            'success' => true,
            'collection' => $products,
            'request' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_name' => 'required|max:100',
            'category_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ]);

        if ($request->image) {
            //getting the position of ; in image file
            $position = strpos($request->image, ';');
            // getting the str for image extension
            $sub = substr($request->image, 0, $position);
            //getting the extension of image
            $ext = explode('/', $sub)[1];


            $name = time() . "." . $ext;
            $img = Image::make($request->image)->resize(240, 200);
            $upload_path = 'backend/img/product/';

            $image_url = $upload_path . $name;

            $img->save($image_url);
            $data = $request->all();
            $data['image'] = $image_url;

            $product = Product::create(
                $data
            );

            return response()->json([
                'success' => true,
                'message' => 'Product Successfully Created',
                'product' => $product
            ]);
        } else {

            $product = Product::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Product Successfully Created',
                'product' => $product
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->where('products.id', '=', $id)
            ->whereNull('products.deleted_at')
            ->first([
                'products.id',
                'category_id',
                'product_name',
                'product_code',
                'root',
                'buying_price',
                'selling_price',
                'supplier_id',
                'buying_date',
                'image',
                'product_quantity',
                'suppliers.name'
            ]);
        //
        return response()->json([
            'success' => true,
            'product' => $products,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'product_name' => 'required|max:100',
            'category_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ]);

        if ($request->image) {
            //getting the position of ; in image file
            $position = strpos($request->image, ';');
            // getting the str for image extension
            $sub = substr($request->image, 0, $position);
            //getting the extension of image
            $ext = explode('/', $sub)[1];


            $name = time() . "." . $ext;
            $img = Image::make($request->image)->resize(240, 200);
            $upload_path = 'backend/img/product/';

            $image_url = $upload_path . $name;

            $img->save($image_url);
            $data = $request->all();
            $data['image'] = $image_url;

            $product = Product::find($id)->update(
                $data
            );

            return response()->json([
                'success' => true,
                'message' => 'Product Successfully Created',
                'product' => $product
            ]);
        } else {

            $product = Product::find($id)->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Product Successfully Created',
                'product' => $product
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
        $deleted = Product::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product successfully deleted',
            'deleted' => $deleted
        ]);
    }

    public function getCategoryAndSupplier()
    {
        $category = DB::table('categories')->get(['id', 'category_name']);
        $supplier = DB::table('suppliers')->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'supplier' => $supplier,
            'category' => $category
        ]);
    }
}

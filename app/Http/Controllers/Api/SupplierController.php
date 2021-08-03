<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $key = $request->q;
     
        $sup = Supplier::where('name','like',"%".$key."%")->paginate(10);
        return response()->json(['success' => true, 'collection' => $sup, 'request' => $request->all()]);
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
        $validated = $request->validate(
            [
                'name' => 'required|max:255|unique:suppliers',
                'email' => 'required|email',
                'phone' => 'required|unique:employees',
                'address' => 'required|max:255' ,
            ]);

            if($request->photo){
                //getting the position of ; in image file
                $position = strpos($request->photo, ';');
                // getting the str for image extension
                $sub = substr($request->photo, 0, $position);
                //getting the extension of image
                $ext = explode('/', $sub)[1];

                
                $name = time().".".$ext;
                $img = Image::make($request->photo)->resize(240, 200);
                $upload_path = 'backend/img/supplier/';

                $image_url = $upload_path.$name;

                $img->save($image_url);
                $data = $request->all();
                $data['photo'] = $image_url;

                $supplier = Supplier::create(
                    $data
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier Successfully Created',
                    'supplier' => $supplier
                ]);
            } else {
                $supplier = Supplier::create($request->all());

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier Successfully Created',
                    'supplier' => $supplier
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
        
        $supplier = Supplier::where('id', $id)
        ->get(['name', 'email', 'phone', 'address', 'photo', 'shop_name'])
        ->first();

        return response()->json(
            [
                'success' => true,
                'supplier' => $supplier
            ]
            );
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
        $validated = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'required|unique:employees',
                'address' => 'required|max:255',
            ]);

            if($request->photo){
                //getting the position of ; in image file
                $position = strpos($request->photo, ';');
                // getting the str for image extension
                $sub = substr($request->photo, 0, $position);
                //getting the extension of image
                $ext = explode('/', $sub)[1];

                
                $name = time().".".$ext;
                $img = Image::make($request->photo)->resize(240, 200);
                $upload_path = 'backend/img/supplier/';

                $image_url = $upload_path.$name;

                $img->save($image_url);
                $data = $request->all();
                $data['photo'] = $image_url;

                $supplier = Supplier::where('id', $id)->update(
                    $data
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Updated',
                    'supplier' => $supplier
                ]);
            } else {
                $supplier = Supplier::where('id', $id)->update($request->all());

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Updated',
                    'supplier' => $supplier
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
        $deleted = Supplier::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier successfully deleted',
            'deleted' => $deleted
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = $request->q;
     

        $emp = Employee::where('name','like',"%".$key."%")->paginate(10);
        return response()->json(['success' => true, 'collection' => $emp, 'request' => $request->all()]);
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
                'name' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'required|unique:employees',
                'salary' => 'required',
                'address' => 'required|max:255' ,
                'joining_date' => 'required'
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
                $upload_path = 'backend/img/employee/';

                $image_url = $upload_path.$name;

                $img->save($image_url);
                $data = $request->all();
                $data['photo'] = $image_url;

                $employee = Employee::create(
                    $data
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Created',
                    'employee' => $employee
                ]);
            } else {
                $employee = Employee::create($request->all());

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Created',
                    'employee' => $employee
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
        $employee = Employee::where('id', $id)
        ->get(['name', 'email', 'phone','salary', 'address', 'photo', 'nid', 'joining_date'])
        ->first();

        return response()->json(
            [
                'success' => true,
                'employee' => $employee
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
                'phone' => 'required',
                'salary' => 'required',
                'address' => 'required|max:255' ,
                'joining_date' => 'required'
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
                $upload_path = 'backend/img/employee/';

                $image_url = $upload_path.$name;

                $img->save($image_url);
                $data = $request->all();
                $data['photo'] = $image_url;

                $employee = Employee::where('id', $id)->update(
                    $data
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Updated',
                    'employee' => $employee
                ]);
            } else {
                $employee = Employee::where('id', $id)->update($request->all());

                return response()->json([
                    'success' => true,
                    'message' => 'Employee Successfully Updated',
                    'employee' => $employee
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
        $deleted = Employee::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee successfully deleted',
            'deleted' => $deleted
        ]);
    }
}

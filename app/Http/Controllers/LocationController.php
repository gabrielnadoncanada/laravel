<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{   
     /** 
    *  Return current database locations as a input selector
    */
    public function index()
    {
        $locations = Location::orderBy('id')->paginate();
        return View('add_image', compact('locations'));
    }
    
     /** 
    *  Validate the user forms
    *  @param  $data
    */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'bail|required'
        ]);
    }

     /** 
    *  Store the new location in the database
    *  @param  $request
    */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
    
        $location = $request->all();
        Location::create($location);
        return redirect('/image_add');
    }
}

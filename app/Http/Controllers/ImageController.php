<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Image_user;
use App\Location;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{   

     /**
     *  Return random user images on the welcome view
     * */
    public function index()
    {
        $images = Image::inRandomOrder()->paginate(9);
        return View('welcome', compact('images'));
    }

    /** 
    *  Return users images by location_id
    *  @param  $id
    */
    public function view($id)
    {
        $images = DB::table('images')
        ->where('location_id', 'like', '%' . $id . '%')
        ->get();

        $location = DB::table('locations')
        ->where('id', 'like', '%' . $id . '%')
        ->get()->first();
        $users = DB::table('users')
        ->where('id', 'like', '%' . $images[0]->user_id . '%')
        ->get()->first();
        
        return View('image', compact('images','location', 'users'));
    }

     /** 
    *  Delete the related images by id
    *  @param  $id
    */
    public function delete($id)
    {
        $image = Image::destroy($id);
        return redirect('/');
    }

     /** 
    *  Return the view to add an images
    */
    public function create()
    {
        return View('add_image');
    }

     /** 
    *  Validate the form field
    *  @param  $data
    */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'location_id' => 'bail|required',
            'image' => 'image|max:20000|required'
        ]);
    }
    
     /** 
    *  Resize and store the uploaded users images
    *  @param  $request
    */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        if ($request->image){
            $path = basename ($request->image->store('images', 'public'));
            $image = InterventionImage::make($request->image)->widen(250)->encode();
            Storage::put('public/thumbs/' . $path, $image);
        }
        Image::create([
            'location_id' => request('location_id'),
            'user_id' => auth()->id(),
            'name' => $path    
        ]);
        return redirect('/');
    }

     /** 
    *  Return current locations for the search field
    *  @param  $request
    */
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('locations')
                    ->where('name', 'like', '%' . $query . '%')
                    ->orderBy('name', 'asc')
                    ->get();
            } 
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '<li><a href="/images/'.$row->id.'">' . $row->name . '</a></li>';
                }
            } else {
                $output = '';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }

     /** 
    *  Manage images report by users session
    *  @param  $request
    */
    public function report(Request $request)
    {

        // Regarder dans la base de donnees si l'utilisateur a deja report cette image.
        $data = DB::table('image_user')->where([
            ['user_id', 'like', '%' .  auth()->id() . '%'],
            ['image_id', 'like', '%' .  $request->id() . '%'],
        ])->get();

        // Regarder dans la base de donnes si l'image a deja ete reporter dans le passer
        $data2 = DB::table('image_user')->where([
            ['image_id', 'like', '%' .  $request->id() . '%'],
        ])->get();
        $total_row = $data->count();
        $total_row2 = $data2->count();
        if ($total_row2 == 1)
        {

        }
        if ($total_row == 0)
        {
            // Création d'une nouvelle instance de image_user
            $image_user = new Image_user; 
 
            // Met le titre et le contenu qui provient du formulaire dans $image_user
            $image_user->alert = 1; 
            $image_user->user_id = auth()->id(); 
            $image_user->image_id = $request->id; 
    
            // Enregistrement dans la base de données
            $image_user->save();
            return redirect('/')->with('status', "merci");
        }
        else {
            return redirect('/')->with('status', "vous ne pouvez pas reporter une image 2 fois");
        } 
    }

     /** 
    *  Edit the target images
    *  @param  $image
    */
    public function edit(Image $image)
    {
        $image = Image::pluck('location_id', 'name');
        return View('edit', compact('image'));
    }
}

<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Form;
  
class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileUpload');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        $validator = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|min:5|max:191',
            'address' => 'required',
            'phone' => 'required|min:8|max:11'
        ]);
        // dd($request);
        if ($validator) {
            $name = $request->name;
            $address = $request->address;
            $phone = $request->phone;
            $gender = $request->gender;

            $imageName = $name.'.'.$request->image->extension();       
            $request->image->move(public_path('image/form'), $imageName);
            $filepath = '/image/form/'.$imageName;
                    //Data insert
            $form = new Form();
            $form->name = $name;
            $form->address = $address;
            $form->phone = $phone;
            $form->gender = $gender;
            $form->file = $filepath;
            $form->save();
            return redirect()->route('/forms')->with('successMsg','New Form is ADDED in your data');
        } else {
            return redirect::back()->withErrors($validator);
        }
    }
}

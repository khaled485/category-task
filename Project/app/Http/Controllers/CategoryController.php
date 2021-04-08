<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Auth\Events\Validate;
use Category as GlobalCategory;
use GrahamCampbell\ResultType\Success;

class CategoryController extends Controller

{
    public function index(Request $request)
    {
        //Tree View 
        $categories = Category::whereNull('category_id')
            ->with('childrenCategories')
            ->get();
        //

        //Search
        $Allcategories=category::when($request->search,function($q)use($request){
           return $q->where('name','like','%' . $request->search . '%');

        })->paginate(6);
        //
        
        return view('category', compact(['categories', 'Allcategories']));
    }//end of index


    public function store(Request $request )
    {

        $request->validate([
          'name'  => 'required',
        ]);//end of validate
  
        $request_data = $request->except('');
        category::create($request_data);

        return redirect()->route('categories.index');

        
    }//end of store



    public function destroy(Request $request,$id, category $category_1)
    {


        $child_array = []; // array for id's of all sub categories
        $i = 0; // counter
        
        $childs= $this->getChildCategories($id, $child_array, $i);
        
        for($y =count($childs)-1  ; $y >= 0 ;$y--) $category_1->findOrFail( $childs[$y])->delete();//for loop to delete the parent and childs
        
        return redirect()->route('categories.index');

    }//end of delete


    // tha function that get all sub categories vea array

    public function getChildCategories($id, $child_array, $i)
    {
        $categories = Category::select()->with('childrenCategories')->where('category_id', $id)->get();

        $child_array[$i] = $id;

        $i = $i + 1;

        foreach ($categories as $category) {

            $child_array[$i] = $category->id;
            $child_array[$i];
            $i = $i + 1;

            if (isset($category->childrenCategories)) {

                foreach ($category->childrenCategories as $child) {

                    $child_array[$i] = $child->id;
                    $i = $i + 1;


                    $this->getChildCategories($child->id, $child_array, $i);
                }//end of foreach

            } // end of if

        }//end of foreach

        return $child_array;

    }//end of function
    
}//end of Controller

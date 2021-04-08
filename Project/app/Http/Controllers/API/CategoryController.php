<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Traits\GeneralTrait;    
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CategoryController extends Controller
{
    use GeneralTrait;

      
    public function get_all_categories(Request $request)
    {
       
        $Allcategories=Category::all();

       return $this->returnData("data", $Allcategories, "all categories and sub-categories");

    }//end of get_all_categories

   
    public function get_category(Request $request)
    {   
        
        if(is_null($request->id)){return $this->returnError('S4000','You must enter the ID variable');}
        
         $categories = Category::select()->with('childrenCategories')->where('category_id', $request->id)->get();
        return $this->returnData("data", $categories, "all sub-categories of entered ID  ");

    }//end of get_category

}//end of Controller

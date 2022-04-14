<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class CategoryController extends Controller
{
    public function AllCat()
    {
        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()->paginate(5);
        $categories = Category::latest()->paginate(5);
        $trachCat = Category::onlyTrashed()->latest()->paginate(3);
        // $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories', 'trachCat'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'category_name' => 'required|unique:categories|max:255',


            ],
            [
                'category_name.required' => "Please Input Category Name",
                'category_name.max' => 'Category Less Then 255Chars',

            ]
        );
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success', 'Category Inserted Successfull');
    }


    // EDIT FUNCTION START 

    public function Edit($id)
    {
        $categories_edit = Category::find($id);
        return view('admin.category.edit', compact('categories_edit'));
        // return view('admin.category.edit');

    }
    // UPDATE function START 
    public function Update(Request $request, $id)
    {
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return Redirect()->route('all.category')->with('success', 'Category Update Successfull');
    }

    // DELETE function
    public function SoftDeletes($id)
    {
        //    $delete = Category::find::($id)->delete();
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category delete Successfull');
    }
    // Restore function 
    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restore Successfull');
    }
    // PDelete function 
    public function Pdelete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category PDelete Successfull');
    }
}

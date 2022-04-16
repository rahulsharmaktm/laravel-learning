<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    // ALL BRAND 
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.Brand.index', compact('brands'));
    }
    // ADD BRAND 
    public function StoreBrand(Request $request)
    {
        $validateData = $request->validate(
            [
                'brand_name' => 'required|unique:brands|max:255',
                'brand_image' => 'required|mimes:jpg.jpeg,png',
            ],
            [
                'brand_name.required' => "Please Input Brnad Name",
                'brand_image.max' => 'Brand Less Then 255Chars',
            ]
        );
        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(100, 100)->save('image/brand/' . $name_gen);
        $last_img = 'image/brand/' . $name_gen;
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);
        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }
    // EDIT BRAND 
    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view('admin.Brand.edit', compact('brands'));
    }
    //UPDATE BRAND 
    public function Update(Request $request, $id)
    {
        $validateData = $request->validate(
            [
                'brand_name' => 'required|max:255',
            ],
            [
                'brand_name.required' => "Please Input Brnad Name",
                'brand_image.max' => 'Brand Less Then 255Chars',
            ]
        );
        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        if ($brand_image) {
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location . $img_name;
            $brand_image->move($up_location, $img_name);
            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
            ]);
            return Redirect()->back()->with('success', 'Brand Inserted Successfully');
        } else {
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
            ]);
            return Redirect()->back()->with('success', 'Brand Inserted Successfully');
        }
    }
    public function Delete($id)
    {
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);
        Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand Delete Successfully');
    }
    // THIS IS FOR MULTI IMAGE ALL METHODS //
    public function Multipic()
    {
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }
    // ADD MULTI IMAGE 
    public function AddMultip(Request $request)
    {
        $image = $request->file('image');

        foreach ($image as $multi_img) {
            $name_gen = hexdec(uniqid()) . '.' . $multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(100, 100)->save('image/multi/' . $name_gen);
            $last_img = 'image/multi/' . $name_gen;
            Multipic::insert([
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        } //end of the foreach
        return Redirect()->back()->with('success', 'Multi Image Inserted Successfully');
    }
}

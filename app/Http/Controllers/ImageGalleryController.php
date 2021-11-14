<?php

namespace App\Http\Controllers;

use App\Models\ImageGallery;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $images = ImageGallery::get();
        return view('image-gallery', compact('images'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('image'), $input['image']);
        $input['title'] = $request->title;
        ImageGallery::create($input);
        return back()->with('success', 'Image Uploaded Successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ImageGallery::find($id)->delete();
        return back()->with('success', 'Image Removed Succssfully');
    }
}

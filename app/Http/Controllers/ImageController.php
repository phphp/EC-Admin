<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::orderBy('id', 'desc')->paginate(10);
        return view('admin/image/index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/image/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'title'         => 'string|max:255',
            'alt'           => 'string|max:255',
            'internal'      => 'required|boolean',
            'src'           => 'nullable|string|max:255',
            'image'         => 'nullable|image|max:2000000',
        ]);
        // 根据 internal 判断必填的字段
        $v->sometimes('src', 'required', function ($request) {
            return ! $request->internal;
        });
        $v->sometimes('image', 'required', function ($request) {
            return $request->internal;
        });
        if ($v->fails()) return back()->withErrors($v)->withInput();

        $image = new Image($request->all());

        if ( $request->internal ) {
            $dirPath = getImageUploadsPath();
            $path = Storage::disk('public')->putFile($dirPath, new File($request->image->getRealPath()));
            list($width, $height) = getimagesize($request->image->path());
            $image->mime_type = $request->image->getMimeType();
            $image->filesize = $request->image->getSize();
            $image->width = $width;
            $image->height = $height;
            $image->internal = $request->internal;
        } else {
            $path = $request->src;
        }

        $image->src = $path;
        $image->save();
        return redirect()->route('image.index')->with('message', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return view('admin/image/edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $v = \Validator::make($request->all(), [
            'title'         => 'string|max:255',
            'alt'           => 'string|max:255',
            'internal'      => 'required|boolean',
            'src'           => 'nullable|string|max:255',
            'image'         => 'nullable|image|max:2000000',
        ]);
        // 根据 internal 判断必填的字段
        $v->sometimes('src', 'required', function ($request) use ($image) {
            return !$request->internal && $image->internal;
        });
        $v->sometimes('image', 'required', function ($request) use ($image) {
            return $request->internal && !$image->internal;
        });
        if ($v->fails()) return back()->withErrors($v)->withInput();

        $image->fill($request->input());

        // 内部图片，并上传了新图像
        if ( $request->internal && $request->hasFile('image') ) {
            $dirPath = getImageUploadsPath();
            $path = Storage::disk('public')->putFile($dirPath, new File($request->image->getRealPath()));
            list($width, $height) = getimagesize($request->image->path());
            $image->mime_type = $request->image->getMimeType();
            $image->filesize = $request->image->getSize();
            $image->width = $width;
            $image->height = $height;
        // 外部图像，并添加了地址
        } elseif ( !$request->internal ) {
            $path = $request->src;
            $image->mime_type = null;
            $image->filesize = null;
            $image->width = null;
            $image->height = null;
            Storage::disk('public')->delete($image->getOriginal('src'));
        // 内部图像，没有上传新图像
        } else {
            $path = $image->getOriginal('src');
        }

        $image->src = $path;
        $image->save();
        return redirect()->route('image.index')->with('message', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->getOriginal('src'));
        $image->banners()->detach();
        $image->delete();
        return redirect()->route('image.index')->with('message', '删除成功');
    }
}

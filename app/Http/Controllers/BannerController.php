<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Banner;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->paginate(10);
        return view('admin/banner/index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/banner/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $v = \Validator::make($request->all(), [
        //     'name'          => 'string|max:255',
        //     'description'   => 'string|max:255',

        //     'title'         => 'string|max:255',
        //     'alt'           => 'string|max:255',
        //     'internal'      => 'required|boolean',
        //     'src'           => 'nullable|string|max:255',
        //     'image'         => 'nullable|image|max:2000000',
        // ]);
        // // 根据 internal 判断必填的字段
        // $v->sometimes('src', 'required', function ($request) {
        //     return ! $request->internal;
        // });
        // $v->sometimes('image', 'required', function ($request) {
        //     return $request->internal;
        // });
        // if ($v->fails()) return back()->withErrors($v)->withInput();


        $imageIdArray = []; // 用于关联
        foreach (json_decode($request->images) as $k => $v) {
            // 根据上传类型选择储存数据
            if ( $v->type == 0 ) {
                $image = new Image();
                $image->title = $v->title;
                $image->alt = $v->alt;
                $image->src = $v->src;
                $image->internal = 0;
                $image->save();
                $imageIdArray[$image->id] = ['sort' => $k+1];
            } elseif ( $v->type == 1 ) {
                $image = new Image();
                $dirPath = getImageUploadsPath();
                $path = Storage::disk('public')->putFile($dirPath, new File($request['image'.$v->no]->getRealPath()));
                list($width, $height) = getimagesize($request['image'.$v->no]->path());
                $image->mime_type = $request['image'.$v->no]->getMimeType();
                $image->filesize = $request['image'.$v->no]->getSize();
                $image->width = $width;
                $image->height = $height;
                $image->internal = 1;
                $image->title = $v->title;
                $image->alt = $v->alt;
                $image->src = $path;
                $image->save();
                $imageIdArray[$image->id] = ['sort' => $k+1];
            } else {
                $imageIdArray[$v->image_id] = ['sort' => $k+1];
            }
        }

        // 插入 banner 及关联
        $banner = new Banner($request->all());
        $banner->save();
        $banner->images()->attach($imageIdArray);

        return json($banner, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
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
        $banner = Banner::with(['images' => function ($query) {
            $query->orderBy('pivot_sort', 'asc');
        }])->find($id);
        return view('admin/banner/edit', compact('banner'));
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
        $imageIdArray = []; // 用于关联
        foreach (json_decode($request->images) as $k => $v) {
            // 根据上传类型选择储存数据
            if ( $v->type == 0 && !$v->image_id ) {
                $image = new Image();
                $image->title = $v->title;
                $image->alt = $v->alt;
                $image->src = $v->src;
                $image->internal = 0;
                $image->save();
                $imageIdArray[$image->id] = ['sort' => $k+1];
            } elseif ( $v->type == 1 && !$v->image_id ) {
                $image = new Image();
                $dirPath = getImageUploadsPath();
                $path = Storage::disk('public')->putFile($dirPath, new File($request['image'.$v->no]->getRealPath()));
                list($width, $height) = getimagesize($request['image'.$v->no]->path());
                $image->mime_type = $request['image'.$v->no]->getMimeType();
                $image->filesize = $request['image'.$v->no]->getSize();
                $image->width = $width;
                $image->height = $height;
                $image->internal = 1;
                $image->title = $v->title;
                $image->alt = $v->alt;
                $image->src = $path;
                $image->save();
                $imageIdArray[$image->id] = ['sort' => $k+1];
            } else {
                $imageIdArray[$v->image_id] = ['sort' => $k+1];
            }
        }

        // 插入 banner 及关联
        $banner = Banner::find($id);
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->save();
        $banner->images()->sync($imageIdArray);

        return json($banner, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        // $banner->images()->detach(); // banner 软删除，保留关联
        $banner->delete();
        return redirect()->route('banner.index')->with('message', '删除成功');
    }
}

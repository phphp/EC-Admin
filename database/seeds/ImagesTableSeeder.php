<?php

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::create([
            'title' => '上传头像默认展示图',
            'alt' => '上传头像默认展示图',
            'internal' => 1,
            'src' => 'uploads/avatars/default/default.jpg',
            'mime_type' => 'image/jpeg',
            'width' => 255,
            'height' => 255,
            'filesize' => 13663,
        ]);
        Image::create([
            'title' => '默认大号头像',
            'alt' => '默认大号头像',
            'internal' => 1,
            'src' => 'uploads/avatars/default/l.jpg',
            'mime_type' => 'image/jpeg',
            'width' => 100,
            'height' => 100,
            'filesize' => 11409,
        ]);
        Image::create([
            'title' => '默认中号头像',
            'alt' => '默认中号头像',
            'internal' => 1,
            'src' => 'uploads/avatars/default/m.jpg',
            'mime_type' => 'image/jpeg',
            'width' => 70,
            'height' => 70,
            'filesize' => 6662,
        ]);
        Image::create([
            'title' => '默认小号头像',
            'alt' => '默认小号头像',
            'internal' => 1,
            'src' => 'uploads/avatars/default/s.jpg',
            'mime_type' => 'image/jpeg',
            'width' => 50,
            'height' => 50,
            'filesize' => 4153,
        ]);
    }
}

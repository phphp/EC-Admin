<?php
namespace App\Models;

class Avatar
{
    /**
     * 生成头像的临时文件
     * 在 AppServiceProvider 检查图片的时候用到，顺便生成临时文件
     */
    public static function makeTmpImage($value, $fileName)
    {
        file_put_contents(self::tmpImagePath($fileName), base64_decode( preg_replace('#^data:image/\w+;base64,#i', '', $value) ));

        if( exif_imagetype(self::tmpImagePath($fileName)) != IMAGETYPE_JPEG )
            throw new \Exception('错误的图片文件');
    }

    /**
     * 生成头像，返回存在数据库的头像地址
     */
    public static function saveAvatar($ID, $avatarFolderPath)
    {
        $idToDir = self::IDToDir($ID);
        $userAvatarPath = public_path($avatarFolderPath) . '/' . $idToDir;
        if ( ! file_exists($userAvatarPath) )
        {
            mkdir($userAvatarPath, 0755, true);
        }

        // 用验证时候生成的临时文件
        // intervention/image
        \Image::make(self::tmpImagePath('avatarL'))->resize(200, 200)->save($userAvatarPath.'/l.jpg');
        \Image::make(self::tmpImagePath('avatarM'))->resize(100, 100)->save($userAvatarPath.'/m.jpg');
        \Image::make(self::tmpImagePath('avatarS'))->resize(50, 50)->save($userAvatarPath.'/s.jpg');

        return $avatarFolderPath . '/' . $idToDir;
    }


    /**
     * 返回新头像完整路径
     * @param int $userID 用户 ID
     * @return str ID 转化为目录的路径，如 0/00/00/01
     */
    public static function IDToDir($userID)
    {
        $userID = sprintf("%07d", $userID);
        $rs = '';
        for ($i=0; $i < 3 ; $i++) {
            $dir = substr($userID,-2);
            $userID = substr($userID, 0, -2);
            $rs = $dir.'/' . $rs;
        }
        $dir = $userID . '/' . $rs;
        return rtrim($dir, '/');
    }

    /**
     * 临时头像文件
     */
    public static function tmpImagePath($fileName)
    {
        return public_path('uploads/avatars/tmp/'.$fileName.'.jpg');
    }

}

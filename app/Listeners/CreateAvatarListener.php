<?php

namespace App\Listeners;

use App\Events\CreateAvatar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateAvatarListener
{
    private const ADMIN_AVATAR_PATH = 'uploads/avatars/admin';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminAvatarPath = public_path(SELF::ADMIN_AVATAR_PATH);
    }

    /**
     * Handle the event.
     *
     * @param  CreateAvatar  $event
     * @return void
     */
    public function handle(CreateAvatar $event)
    {
        $idToDir = IDToDir($event->admin->id);
        $userAvatarPath = $this->adminAvatarPath . '/' . $idToDir;

        if ( ! file_exists($userAvatarPath) )
            mkdir($userAvatarPath, 0755, true);

        // 用验证时候生成的临时文件
        // intervention/image
        \Image::make(getTmpImagePath('avatarL'))->resize(200, 200)->save($userAvatarPath.'/l.jpg');
        \Image::make(getTmpImagePath('avatarM'))->resize(100, 100)->save($userAvatarPath.'/m.jpg');
        \Image::make(getTmpImagePath('avatarS'))->resize(50, 50)->save($userAvatarPath.'/s.jpg');

        return SELF::ADMIN_AVATAR_PATH . '/' . $idToDir;
    }
}

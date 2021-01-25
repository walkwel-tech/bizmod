<?php

namespace App\Traits;

/**
 * Basic implementation of ModelLogsToDatabase interface
 */
trait HasAvatar
{
    public function getAvatarColumnName()
    {
        return 'avatar';
    }

    public function getAvatarDiskName()
    {
        return 'image';
    }

    public function getSlugAvatarFileName()
    {
        return $this->slug . '.' . $this->getAvatarDefaultExtension();
    }

    public function getSlugAvatarFilePath()
    {
        return $this->getAvatarFolderName() . '/' . $this->getSlugAvatarFileName();
    }

    public function getAvatarDefaultExtension()
    {
        return 'png';
    }

    public function getDefaultAvatarPath()
    {
        return 'default.png';
    }

    public function getAvatarRouteName()
    {
        return 'images.get';
    }

    public function getAvatarFolderName()
    {
        return null;
    }

    public function getAvatarPathName()
    {
        $path = ($this->avatar)
        ? $this->getAttributeValue($this->getAvatarColumnName())
        : $this->getDefaultAvatarPath();

        return $path;
    }


    public function getImage()
    {
        return route($this->getAvatarRouteName(), ['path' => $this->getAvatarPathName(), 'folder' => $this->getAvatarFolderName()]);
    }
}

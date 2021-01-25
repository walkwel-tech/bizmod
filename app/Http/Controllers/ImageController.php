<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    private function sendImage($path, $disk = null, $folder = null)
    {
        // If disk for image is not provided, get controller default.
        if (is_null($disk)) {
            $disk = $this->getDisk();
        }

        if (is_null($folder)) {
            $folder = $this->getFolder();
        }

        try {
            if (Str::is('default.png', $path)) {
                $file = Storage::disk($disk)->get('avatars' . '/' . $path);
            } else {
                $file = Storage::disk($disk)->get($folder . '/' . $path);
            }

            return response($file, 200)->header('Content-Type', 'image/jpeg');
        } catch (FileNotFoundException $e) {
            return response('file not found', 404)->header('Content-Type', 'image/png');
        }
    }

    public function show(Request $request, $path)
    {
        return $this->sendImage($request->path);
    }

    public function showImage(Request $request, $folder, $path)
    {
        return $this->sendImage($path, null, $folder);
    }

    public function avatar(Request $request)
    {
        $user = $request->user();

        return ($user->avatar)
            ? $this->sendImage($user->avatar)
            : $this->sendImage('default-user.png');
    }

    public function store(Request $request)
    {
        $request->validate([
            'avatar' => "required|mimes:jpeg,jpg,png,gif|dimensions:ratio=1/1",
        ]);

        $user         = $this->getUser();
        $old          = $user->avatar;
        $fileName     = $this->saveFile($request, $old, $this->getDisk(), $this->getFolder());
        $user->avatar = $fileName;
        $user->save();

        if ($request->expectsJson()) {
            return $this->sendImage($fileName);
        } else {
            return back();
        }
    }

    public function saveFile(Request $request, $old = null, $disk = 'image', $folder = 'avatars', $inputName = 'avatar')
    {
        $fileName = Str::random(8)
            . "_"
            . $request->file($inputName)->getClientOriginalName();

        Storage::disk($disk)->putFileAs($folder, $request->file($inputName), $fileName);

        if ($old) {
            Storage::disk($disk)->delete("{$folder}/{$old}");
        }

        return $fileName;
    }

    protected function getUser()
    {
        return auth()->user();
    }

    protected function getDisk()
    {
        return 'image';
    }

    protected function getFolder()
    {
        return 'avatars';
    }
}

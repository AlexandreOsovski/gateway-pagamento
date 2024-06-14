<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function pre($dados) : array
    {
        echo '<pre>';
        print_r($dados);
        echo '</pre>';
        die();
    }

//    public function generateQrCode($link)
//    {
//        $qrCode = QrCode::format('svg')->size(250)->generate($link);
//        return $qrCode;
//    }

    public function saveAvatar($request, $user_avatar, $path_to_save)
    {
        $avatar = null;
        $requestImage = $request->file('avatar');
        if ($requestImage) {

            if ($user_avatar) {
                $oldAvatar = public_path('storage/' . $user_avatar);
                if (File::exists($oldAvatar)) {
                    File::delete($oldAvatar);
                    Storage::disk('local')->delete($user_avatar);
                }
            }
            $imageName = md5($requestImage . strtotime('now')) . '.' . strtolower($requestImage->getClientOriginalName());
            $requestImage->move(public_path('storage/' . $path_to_save . '/'), $imageName);
            Storage::disk('local')->put($imageName, ($imageName));
            $avatar = $path_to_save . '/' . $imageName;
        }
        return $avatar;
    }

    public function savePhoto($fileInput, $old_photo, $path_to_save)
    {
        $avatar = null;
        $requestImage = request()->file($fileInput);

        if ($requestImage) {
            if ($old_photo) {
                $oldAvatar = public_path('storage/' . $old_photo);
                if (File::exists($oldAvatar)) {
                    File::delete($oldAvatar);
                }
            }

            $storagePath = public_path('storage/' . $path_to_save);
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            $imageName = md5($requestImage . strtotime('now')) . '.' . strtolower($requestImage->getClientOriginalName());
            $requestImage->move($storagePath, $imageName);
            $avatar = $path_to_save . '/' . $imageName;
        } elseif ($old_photo) {
            $avatar = $old_photo;
        }

        return $avatar;
    }

    public function saveFile($request, $old_photo): string
    {
        $existingFile = $this->getImageByLink($old_photo);
        if ($existingFile) {
            Storage::disk('s3')->delete('public/' . $existingFile);
        }

        $file = $request->file('avatar')->store('public', 's3');
        Storage::disk('s3')->setVisibility($file, 'public');
        $imageUrl = Storage::disk('s3')->url($file);

        return $imageUrl;
    }
    private function getImageByLink($link)
    {
        $fileName = basename($link);
        if($fileName){
            if (Storage::disk('s3')->exists('public/'. $fileName)) {
                return $fileName;
            } else {
                return null;
            }
        }
        return null;

    }


    public function getProductsByCategory($categoryName, $perPage = 12)
    {
        return ProductModel::where('status', 'active')
            ->whereHas('categoryName', function ($query) use ($categoryName) {
                $query->where('name', $categoryName);
            })
            ->with('productPhotos')
            ->with('categoryName')
            ->paginate($perPage);
    }
    public function getProductsByCountry($countryName, $perPage = 12)
    {
        return ProductModel::where('status', 'active')
            ->where('country', $countryName)
            ->with('productPhotos')
            ->with('categoryName')
            ->paginate($perPage);
    }
    public function getProductsByGrape($grape, $perPage = 12)
    {
        return ProductModel::where('status', 'active')
            ->where('grape', $grape)
            ->with('productPhotos')
            ->with('categoryName')
            ->paginate($perPage);
    }

}

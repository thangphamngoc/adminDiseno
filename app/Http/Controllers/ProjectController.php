<?php

namespace App\Http\Controllers;

use App\Model\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $bannerList = DB::table('projects')
            // ->join('ex_nick_images', 'info_nick_fb.id', '=', 'ex_nick_images.info_nick_fb_id')
            // ->join('image_spas', 'ex_nick_images.image_spas_id', '=', 'image_spas.id')
            ->where('projects.status', True)
            ->orderBy('projects.created_at', 'asc')
            ->get();
        foreach ($bannerList as $value) {
            $value->namePicture = Storage::url($value->namePicture);
        }
        // dd($nickList);
        return response($bannerList);
    }


    public function store(Request $request)
    {
        if ($request->hasFile('photos')) {
            $file  = $request->photos;
            if ($file instanceof UploadedFile) {
                $nameUrl = time() . '.' . $file->getClientOriginalName();
                // $filename = $photo->storeAs('photos', $nameUrl);
                $uploadPath = public_path('upload');
                $file->move($uploadPath, $nameUrl);
                $filename = "upload/" . $nameUrl;
            };
            $nick = Projects::create([
                // $request->all(),
                'title' => $request->title,
                // 'titleEn' => $request->titleEn,
                'content' => $request->content,
                // 'contentEn' => $request->contentEn,
                'titlePicture' => $request->titlePicture,
                // 'titlePictureEn' => $request->titlePictureEn,
                'type' => $request->type,
                'address' => $request->address,
                'descreption' => $request->descreption,
                'slud' => $request->slud,

                "namePicture" => $nameUrl,
                "urlPicture" => $filename,
                "ulrLocal" => $filename,


                'create_by' => Auth::user()->name,
                'id_create' => Auth::user()->id,
            ]);
            return response()->json(['success' => 'You have successfully create nick.']);
        }
        return "Falied to upload. Only accept jpg, png photos.";
    }
}

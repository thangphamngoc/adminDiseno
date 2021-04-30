<?php

namespace App\Http\Controllers;

use App\Model\DayAddDetail;
use App\Model\DayAddTotal;
use App\Model\ExNickImage;
use App\Model\Homes;
use App\Model\ImageSpa;
use Illuminate\Http\Request;
use App\Model\NickFb;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\True_;

class HomeBannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bannerList = DB::table('homes')
            // ->join('ex_nick_images', 'info_nick_fb.id', '=', 'ex_nick_images.info_nick_fb_id')
            // ->join('image_spas', 'ex_nick_images.image_spas_id', '=', 'image_spas.id')
            // ->where('info_nick_fb.user_id', Auth::user()->id)
            ->orderBy('homes.sort', 'asc')
            ->get();
        foreach ($bannerList as $value) {
            $value->namePicture = Storage::url($value->namePicture);
        }
        // dd($nickList);
        return response($bannerList);
    }

    public function detailAddDay()
    {
        $nickList = DB::table('info_nick_fb')
            ->where('info_nick_fb.user_id', Auth::user()->id)
            ->where('info_nick_fb.del_active', True)
            ->where('info_nick_fb.status_nick', '1')
            ->orderBy('info_nick_fb.created_at', 'desc')
            ->get();
        return response($nickList);
    }
    public function addDayDetail(Request $request)
    {
        $detailAddDay = DB::table('day_add_friend')
            ->where('day_add_friend.id_create', Auth::user()->id)
            ->where('day_add_friend.date_add', $request->date)
            ->orderBy('day_add_friend.created_at', 'desc')
            ->get();
        return response($detailAddDay);
    }
    public function createAddDay(Request $request)
    {
        $nick = $request->nick_name;
        // dd(Auth::user()->id);
        $dayAddDetail = DayAddDetail::create([
            'nick_name' => $nick["nick_name"],
            'date_add' => $request->date_add,
            'to_number' => $request->to_number,
            'to_number_group' => $request->to_number_group,
            'info_nick_fb_id' => $nick["id"],
            'day_add_total_id' => $request->day_add_total_id,
            'info_employee_id' => $request->info_employee_id,
            'create_by' => Auth::user()->name,
            'id_create' => Auth::user()->id,
        ]);

        $totalDayOld = DayAddTotal::find($request->day_add_total_id);

        $totalDayOld->total_day = $totalDayOld->total_day + $request->to_number;
        $totalDayOld->total_add_group = $totalDayOld->total_add_group + $request->to_number_group;
        $totalDayOld->save();

        $nickOld = NickFb::find($nick["id"]);
        $nickOld->number_friend = $nickOld->number_friend + $request->to_number;
        $nickOld->save();

        return response()->json(['success' => 'You have successfully create daytotal.']);
    }


    public function viewAddDay(Request $request)
    {

        // dd($request->route('id'));
        $viewDay = DB::table('day_add_friend')
            ->where('day_add_friend.day_add_total_id', $request->route('id'))
            ->orderBy('day_add_friend.created_at', 'desc')
            ->get();
        return response($viewDay);
    }

    public function create(Request $request)
    {
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
            $nick = Homes::create([
                // $request->all(),
                'title' => $request->title,
                // 'titleEn' => $request->titleEn,
                'content' => $request->content,
                // 'contentEn' => $request->contentEn,
                'titlePicture' => $request->titlePicture,
                // 'titlePictureEn' => $request->titlePictureEn,
                'sort' => $request->sort,
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


    public function show(Request $request)
    {
        //
    }


    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request)
    {
        // $nickOld = NickFb::where('id',$request->id)->get();
        $nickOld = NickFb::find($request->info_nick_fb_id);
        $nickOld->nick_name = $request->nick_name;
        $nickOld->url_fb = $request->url_fb;
        $nickOld->username_fb = $request->username_fb;
        $nickOld->password_fb = $request->password_fb;
        $nickOld->status_nick = $request->status_nick;
        $nickOld->number_friend = $request->number_friend;
        $nickOld->save();
    }

    public function destroy(Request $request)
    {
        //
    }
}

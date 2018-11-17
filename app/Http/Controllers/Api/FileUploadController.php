<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\handlers\UploadHandler;
use App\Models\User;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $upload_handler = new UploadHandler();
        $user = User::find(1);
        $arr_response = $upload_handler->response;
        $user->avater = $arr_response['files'][0]->url;
        $user->save();
    }
}

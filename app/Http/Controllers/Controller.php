<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     //its just a dummy data object.
    private $storage_url;
    public function __construct(){
        $this->storage_url = env('STORAGE_URL');
        View::share('storage_url', $this->storage_url);
     //   dd(config('global.storage_url'));
    }
    
}

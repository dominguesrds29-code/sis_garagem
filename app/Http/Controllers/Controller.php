<?php

namespace App\Http\Controllers;

use App\Support\Message;
use App\Support\Notify;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $repository;
    protected $Notify;
    protected $Message;

    public function __construct() {
        $this->Notify = new Notify();
        $this->Message = new Message();
    }
}

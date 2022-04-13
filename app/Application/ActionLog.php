<?php

namespace App\Application;

use App\Interfaces\ILogger;
use App\Logger;
use Illuminate\Support\Facades\Auth;

class ActionLog implements ILogger
{
    public function list()
    {
        return Logger::orderBy('log_data', 'DESC')->get()->all();
    }

    public static function create($message)
    {
        self::log($message, Logger::TYPE_CREATE);
        return true;
    }

    public static function update($message)
    {
        self::log($message, Logger::TYPE_UPDATE);
        return true;
    }

    public static function delete($message)
    {
        self::log($message, Logger::TYPE_DELETE);
        return true;
    }

    private function log($message, $type){
        Logger::create([
            'log_acao' => $message,
            'log_user' => Auth::user()->name,
            'log_data' => date('Y-m-d H:i:s'),
            'log_type' => $type,
        ]);
    }

}

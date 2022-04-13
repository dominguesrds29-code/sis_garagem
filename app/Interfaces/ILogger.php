<?php

namespace App\Interfaces;

interface ILogger
{
    public function list();

    public static function create($message);
    public static function update($message);
    public static function delete($message);
}

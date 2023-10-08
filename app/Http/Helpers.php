<?php
use App\Models\Setting;

function setting()
{
    $setting = Setting::first();
    return $setting;
}
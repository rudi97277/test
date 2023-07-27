<?php

namespace App\Traits;


trait AdminInfo
{
    public function getCurrentAdmin()
    {
        return auth()->user();
    }
}

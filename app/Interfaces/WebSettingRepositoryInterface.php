<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface WebSettingRepositoryInterface
{
    public function allGrouped();
    public function update(Request $request): void;
}
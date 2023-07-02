<?php

namespace App\Http\Controllers;

use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class ItemGroupController extends Controller
{
    public function getAllGroups()
    {
        return ItemGroup::where('farm', '=', request()->user()->farm)->get();
    }

    public function save(Request $request) {
        try {
            $validatedData = $request->validate([
               'groupName' => 'required'
            ]);

            $group = new ItemGroup();
            $group->group_name = $validatedData['groupName'];
            $group->farm = request()->user()->farm;
            $group->save();


        } catch (Exception $e) {
            Log::error('Error saving group: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FarmDetails;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view()
    {
        $farms = FarmDetails::all();
        return view('pages.laravel-examples.user-profile', compact('farms'));
    }
    public function create()
    {
        return view('pages.profile');
    }

    public function update()
    {

        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'about' => 'required:max:150',
            'location' => 'required',
            'farm' => 'required|numeric'
        ]);

        auth()->user()->update($attributes);
        return back()->withStatus('Profile successfully updated.');

}
}

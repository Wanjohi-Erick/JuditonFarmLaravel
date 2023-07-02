<?php

namespace App\Http\Controllers;

use App\Models\Vendors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorsController extends Controller
{
    public function getAllVendors()
    {
        return Vendors::where('farm', '=', request()->user()->farm)->get();
    }

    public function save(Request $request) {
        try {
            $validatedData = $request->validate([
                'contact_name' => 'required',
                'company' => 'required',
                'phone' => 'required|phone',
                'item_group' => 'required|numeric',
            ]);

            $vendor = new Vendors();
            $vendor->contact_name = $validatedData['contact_name'];
            $vendor->company = $validatedData['company'];
            $vendor->phone = $validatedData['phone'];
            $vendor->item_group = $validatedData['item_group'];
            $vendor->farm = request()->user()->farm;
            $vendor->save();


        } catch (Exception $e) {
            Log::error('Error saving vendor: ' . $e->getMessage());
        }
    }
}

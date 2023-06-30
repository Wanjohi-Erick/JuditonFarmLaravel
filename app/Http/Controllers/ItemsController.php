<?php

namespace App\Http\Controllers;

use App\Models\AnimalWeight;
use App\Models\ItemGroup;
use App\Models\Items;
use App\Models\ItemStock;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemsController extends Controller
{
    public function getAllItems() {
        $items = DB::table('items')
            ->select('*')
            ->leftJoin('item_stocks', 'items.id', '=', 'item_stocks.item_id')
            ->get();

        return response()->json($items);
    }

    public function index()
    {
        $items = $this->getAllItems();
        $vendors = Vendors::all();
        $itemGroups = ItemGroup::all();
        return view('pages.items', compact('items', 'itemGroups', 'vendors'));
    }

    public function save(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'itemName' => 'required',
                'uom' => 'required',
                'itemGroup' => 'required',
                'itemCategory' => 'required',
                'itemPrice' => 'required|numeric',
                'reorderLevel' => 'required|numeric',
                'preferredVendor' => 'required|numeric',
                'returnable' => 'nullable',
                'openingStock' => 'required|numeric'
            ]);

            // Handle file upload
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $imagePath = 'images/' . $imageName;
            } else {
                $imagePath = null;
            }

            // Create a new Items instance
            $item = new Items();
            $item->image = $imagePath;
            $item->item_name = $validatedData['itemName'];
            $item->uom = $validatedData['uom'];
            $item->item_group = $validatedData['itemGroup'];
            $item->item_category = $validatedData['itemCategory'];
            $item->item_price = $validatedData['itemPrice'];
            $item->reorder_level = $validatedData['reorderLevel'];
            $item->preferred_vendor = $validatedData['preferredVendor'];
            $item->farm = 1;

            // Save the item data
            if ($item->save()) {
                $id = $item->id;
                $itemStock = new ItemStock();
                $itemStock->amount = $validatedData['openingStock'];
                $itemStock->item_id = $id;
                $itemStock->description = "Opening Stock";
                $itemStock->farm = 1;

                $itemStock->save();
                return redirect()->route('items')->with('success', 'Item data saved successfully.');
            } else {
                return redirect()->route('items')->with('fail', 'Failed to save item data.');
            }
        } catch (\Exception $e) {
            Log::error('Error saving item data: ' . $e->getMessage());
            return redirect()->route('items')->with('fail', 'An error occurred while saving item data.');
        }
    }

    public function find($id)
    {
        $item = Items::find($id);

        return $item;
    }

    public function update(Request $request, $id)
    {
        $item = Items::find($id);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = null;
        }

        $item->img = $imagePath;
        $item->item_id = $request->input('category');
        $item->tag = $request->input('tag');
        $item->date_acquired = $request->input('date_acquired');
        $item->breed = $request->input('breed');
        $item->weight = $request->input('weight');
        $item->date_last_weighed = $request->input('date_last_weighed');
        $item->gender = $request->input('gender');
        $item->description = $request->input('description');

        $item->save();

        $weight = new AnimalWeight();
        $currentWeight = $request->input('weight');
        $weight->weight = $currentWeight;
        $weight->item_id = $id;
        $lastWeight = $this->getLastWeight($id)->weight;
        $weightGained = doubleval($currentWeight) - doubleval($lastWeight);
        $weight->weight_gained = $weightGained;
        $weight->farm = 1;

        $weight->save();
        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Animal updated successfully');
    }

    public function delete($id) {
        $item = Items::find($id);
        $item->delete();

        return redirect() -> back() ->with('success', 'Animal deleted successfully');
    }

    public function view($id) {

        $items = $this->find($id);
        $stock = ItemStock::where('item_id', $id)->get();
        return view('pages.view-item', compact('items', 'stock'));
    }

}

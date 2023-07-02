<?php

namespace App\Http\Controllers;

use App\Models\ItemGroup;
use App\Models\Items;
use App\Models\ItemStock;
use App\Models\Vendors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItemsController extends Controller
{
    public function index()
    {
        $items = $this->getAllItems();
        $vendors = Vendors::where('farm', request()->user()->farm)->get();
        $itemGroups = ItemGroup::where('farm', '=', request()->user()->farm)->get();

        return response()->json([
            'items' => $items,
            'itemGroups' => $itemGroups,
            'vendors' => $vendors,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validation rules
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
                'openingStock' => 'required|numeric',
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

            $user = $request->user();
            $farm = $user->farm;

            $item->farm = $farm;

            // Save the item data
            if ($item->save()) {
                $id = $item->id;
                $itemStock = new ItemStock();
                $itemStock->amount = $validatedData['openingStock'];
                $itemStock->item_id = $id;
                $itemStock->description = "Opening Stock";
                $itemStock->farm = $farm;

                $itemStock->save();
                return response()->json(['message' => 'Item data saved successfully.']);
            } else {
                return response()->json(['error' => 'Failed to save item data.'], 500);
            }
        } catch (Exception $e) {
            Log::error('Error saving item data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while saving item data.'], 500);
        }
    }

    public function show($id)
    {
        $item = $this->find($id);

        return response()->json(['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = Items::find($id);

        // ...

        $item->save();

        // ...

        return response()->json(['message' => 'Item updated successfully']);
    }

    public function destroy($id)
    {
        $item = Items::find($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }

    public function view($id)
    {
        $items = $this->find($id);
        $stock = ItemStock::where('item_id', $id)->get();

        return response()->json([
            'items' => $items,
            'stock' => $stock,
        ]);
    }

    public function getAllItems()
    {
        $items = Items::where('farm', request()->user()->farm)->with(['itemStock' => function ($query) {$query->latest()->first();}])->get();
        return $items;
    }

    public function find($id)
    {
        $item = Items::find($id);

        return $item;
    }

    public function restock(Request $request)
    {
        try {
            // Validation rules
            $validatedData = $request->validate([
                'item' => 'required|numeric',
                'itemPrice' => 'required|numeric',
                'preferredVendor' => 'required|numeric',
                'quantity' => 'required|numeric',
                'transaction_reference' => 'required',
            ]);

            $user = $request->user();
            $farm = $user->farm;

            $itemId = $validatedData['item'];

            $quantityInStock = $this->getCurrentStock($itemId)->amount;
            $restocked = $validatedData['quantity'];
            $itemStock = new ItemStock();
            $itemStock->amount = doubleval($quantityInStock) + doubleval($restocked);
            $itemStock-> item_id = $itemId;
            $itemStock->description = "Restocking";
            $itemStock->farm = $farm;

            if ($itemStock->save()) {
                return response()->json(['message' => 'Item stock updated successfully.']);
            } else {
                return response()->json(['error' => 'Failed to update item stock.'], 500);
            }
        } catch (Exception $e) {
            Log::error('Error saving item data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while saving updating stock.'], 500);
        }
    }

    private function getCurrentStock($id) {
        return ItemStock::where('item_id', $id)->latest()->first();
    }
}

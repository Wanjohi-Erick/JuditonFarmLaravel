<?php

namespace App\Http\Controllers;

use App\Models\AllAnimals;
use App\Models\Breed;
use App\Models\AnimalCategory;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    public function getAllBreeds() {
        $breeds = Breed::with('farmAnimal')->get();
        return $breeds;
    }

    public function populateBreeds() {
        $breeds = $this->getAllBreeds();
        $animals = AnimalCategory::all();
        return view('pages.breeds', compact('breeds', 'animals'));
    }

    public function save(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'animal' => 'required',
        ]);

        // Create a new AllAnimals instance
        $breed = new Breed();
        $breed->name = $validatedData['name'];
        $breed->animal = $validatedData['animal'];

        // Save the breed data
        $breed->save();

        // Redirect the user after saving the breed data
        return redirect()->route('breeds')->with('success', 'Breed added successfully.');
    }

    public function find($id)
    {
        $breed = Breed::find($id);

        return $breed;
    }

    public function update(Request $request, $id)
    {
        $breed = Breed::find($id);

        // Update the breed data
        $breed->name = $request->input('name');
        $breed->animal = $request->input('animal');
        $breed->save();

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Breed updated successfully');
    }

    public function delete($id) {
        $breed = Breed::find($id);
        $breed->delete();

        return redirect() -> back() ->with('success', 'Breed deleted successfully');
    }


}

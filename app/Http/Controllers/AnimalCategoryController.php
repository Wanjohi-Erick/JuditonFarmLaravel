<?php

namespace App\Http\Controllers;

use App\Models\AnimalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalCategoryController extends Controller
{
    public function getAllAnimals()
    {
        $animals = DB::table('animal_categories')
            ->select('animal_categories.id AS id', 'animal_categories.animal AS animal', DB::raw('COUNT(all_animals.id) AS count'))
            ->leftJoin('all_animals', 'animal_categories.id', '=', 'all_animals.animal_id')
            ->groupBy('animal_categories.id', 'animal_categories.animal')
            ->get();

        return response()->json($animals);
    }


    public function show() {
        $animalCategories = $this->getAllAnimals();
        return view('pages.animal-categories', compact('animalCategories'));
    }

    public function save(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // Create a new AllAnimals instance
        $animalCategory = new AnimalCategory();
        $animalCategory->animal = $validatedData['name'];

        // Save the animal data
        $animalCategory->save();

        // Redirect the user after saving the animal data
        return redirect()->route('animal-categories')->with('success', 'Animal category added successfully.');
    }

    public function find($id)
    {
        $animalCategory = AnimalCategory::find($id);

        return $animalCategory;
    }

    public function update(Request $request, $id)
    {
        $animalCategory = AnimalCategory::find($id);

        // Update the FarmAnimal data
        $animalCategory->animal = $request->input('name');
        $animalCategory->save();

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Animal category updated successfully');
    }

    public function delete($id) {
        $animalCategory = AnimalCategory::find($id);
        $animalCategory->delete();

        return redirect() -> back() ->with('success', 'Animal category deleted successfully');
    }
}

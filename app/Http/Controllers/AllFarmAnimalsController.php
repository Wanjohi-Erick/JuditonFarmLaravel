<?php

namespace App\Http\Controllers;

use App\Models\AllAnimals;
use App\Models\AnimalWeight;
use App\Models\Breed;
use App\Models\AnimalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AllFarmAnimalsController extends Controller
{
    public function getAllAnimals() {
        $animals = AllAnimals::with(['farmAnimal', 'animalBreed'])->get();
        return $animals;
    }

    public function index()
    {
        $animals = $this->getAllAnimals();
        $breeds = Breed::all();
        $animalCategories = AnimalCategory::all();
        return view('pages.animals', compact('animals', 'breeds', 'animalCategories'));
    }

    public function save(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'tag' => 'required',
                'date_acquired' => 'required|date',
                'category' => 'required',
                'breed' => 'required',
                'weight' => 'required|numeric',
                'date_last_weighed' => 'required|date',
                'gender' => 'required',
                'description' => 'nullable',
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

            // Create a new AllAnimals instance
            $animal = new AllAnimals();
            $animal->img = $imagePath;
            $animal->tag = $validatedData['tag'];
            $animal->date_acquired = $validatedData['date_acquired'];
            $animal->animal_id = $validatedData['category'];
            $animal->breed = $validatedData['breed'];
            $animal->weight = $validatedData['weight'];
            $animal->date_last_weighed = $validatedData['date_last_weighed'];
            $animal->gender = $validatedData['gender'];
            $animal->description = $validatedData['description'];

            // Save the animal data
            if ($animal->save()) {
                $id = $animal->id;
                $weight = new AnimalWeight();
                $weight->weight = $request->input('weight');
                $weight->animal_id = $id;
                $weight->weight_gained = $request->input('weight') - $this->getLastWeight($id);
                $weight->farm = 1;

                $weight->save();
                return redirect()->route('animals')->with('success', 'Animal data saved successfully.');
            } else {
                return redirect()->route('animals')->with('fail', 'Failed to save animal data.');
            }
        } catch (\Exception $e) {
            Log::error('Error saving animal data: ' . $e->getMessage());
            return redirect()->route('animals')->with('fail', 'An error occurred while saving animal data.');
        }
    }

    public function find($id)
    {
        $animal = AllAnimals::find($id);

        return $animal;
    }

    public function update(Request $request, $id)
    {
        $animal = AllAnimals::find($id);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = null;
        }

        $animal->img = $imagePath;
        $animal->animal_id = $request->input('category');
        $animal->tag = $request->input('tag');
        $animal->date_acquired = $request->input('date_acquired');
        $animal->breed = $request->input('breed');
        $animal->weight = $request->input('weight');
        $animal->date_last_weighed = $request->input('date_last_weighed');
        $animal->gender = $request->input('gender');
        $animal->description = $request->input('description');

        $animal->save();

        $weight = new AnimalWeight();
        $currentWeight = $request->input('weight');
        $weight->weight = $currentWeight;
        $weight->animal_id = $id;
        $lastWeight = $this->getLastWeight($id)->weight;
        $weightGained = doubleval($currentWeight) - doubleval($lastWeight);
        $weight->weight_gained = $weightGained;
        $weight->farm = 1;

        $weight->save();
        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Animal updated successfully');
    }

    public function delete($id) {
        $animal = AllAnimals::find($id);
        $animal->delete();

        return redirect() -> back() ->with('success', 'Animal deleted successfully');
    }

    public function view($id) {

        $animals = $this->find($id);
        $weights = AnimalWeight::where('animal_id', $id)->get();
        return view('pages.view-animal', compact('animals', 'weights'));
    }

    public function getLastWeight($id) {
        return AnimalWeight::where('animal_id', $id)->latest()->first();
    }

}

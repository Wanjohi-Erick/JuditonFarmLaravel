<?php

namespace App\Http\Controllers;

use App\Models\AllAnimals;
use App\Models\AnimalTreatment;
use App\Models\AnimalWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AnimalTreatmentController extends Controller
{
    public function getAllAnimalTreatments() {
        $animalTreatments = AnimalTreatment::with(['farmAnimal'])->get();
        return $animalTreatments;
    }

    public function index()
    {
        $animalTreatments = $this->getAllAnimalTreatments();
        $animals = AllAnimals::all();
        return view('pages.animal-treatment', compact('animalTreatments', 'animals'));
    }

    public function save(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'animal' => 'required',
                'type' => 'required',
                'product' => 'required',
                'application_method' => 'required',
                'days_until_withdrawal' => 'required|numeric',
                'technician' => 'required',
                'dosage' => 'required|numeric',
                'treatment_date' => 'required|date',
                'body_part' => 'required',
                'booster_date' => 'required|date',
                'total_cost' => 'required|numeric',
                'description' => 'nullable',
            ]);

            // Create a new AnimalTreatment instance
            $animalTreatment = new AnimalTreatment();
            $animalTreatment->animal_id = $validatedData['animal'];
            $animalTreatment->type = $validatedData['type'];
            $animalTreatment->product = $validatedData['product'];
            $animalTreatment->application_method = $validatedData['application_method'];
            $animalTreatment->days_until_withdrawal = $validatedData['days_until_withdrawal'];
            $animalTreatment->technician = $validatedData['technician'];
            $animalTreatment->dosage = $validatedData['dosage'];
            $animalTreatment->treatment_date = $validatedData['treatment_date'];
            $animalTreatment->body_part = $validatedData['body_part'];
            $animalTreatment->booster_date = $validatedData['booster_date'];
            $animalTreatment->total_cost = $validatedData['total_cost'];
            $animalTreatment->description = $validatedData['description'];

            // Save the animal data
            if ($animalTreatment->save()) {
                return redirect()->route('animalTreatment')->with('success', 'Treatment recorded successfully.');
            } else {
                return redirect()->route('animalTreatment')->with('fail', 'Failed to record treatment.');
            }
        } catch (\Exception $e)
        {  Log::error('Error recording treatment: ' . $e->getMessage());
            return redirect()->route('animalTreatment')->with('fail', 'An error occurred while recording treatment.');
        }
    }

    public function find($id)
    {
        $animalTreatment = AnimalTreatment::find($id);

        return $animalTreatment;
    }

    public function update(Request $request, $id)
    {
        $animalTreatment = $this->find($id);
        $animal->animal_id = $request->input('tag');
        $animal->type = $request->input('type');
        $animal->product = $request->input('product');
        $animal->application_method = $request->input('application_method');
        $animal->days_until_withdrawal = $request->input('days_until_withdrawal');
        $animal->technician = $request->input('technician');
        $animal->dosage = $request->input('dosage');
        $animal->treatment_date = $request->input('treatment_date');
        $animal->body_part = $request->input('body_part');
        $animal->booster_date = $request->input('booster_date');
        $animal->total_cost = $request->input('total_cost');
        $animal->description = $request->input('description');


        $animalTreatment->save();

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Treatment updated successfully');
    }

    public function delete($id) {
        $animalTreatment = AnimalTreatment::find($id);
        $animalTreatment->delete();

        return redirect() -> back() ->with('success', 'Treatment deleted successfully');
    }
    public function view($id) {

        $animalsTreatment = $this->find($id);
        return view('pages.animal-treatment', compact('animalsTreatment',));
    }

}

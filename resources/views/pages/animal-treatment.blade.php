<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="animals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="AnimalsTreatment"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @if(session('success'))
                <div id="successMessage" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('fail'))
                <div id="failureMessage" class="alert alert-danger">
                    {{ session('fail') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Treatment table</h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a onclick="openModal()" class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Treatment</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tag
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Type
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Product
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Withdrawal Date
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Booster Date
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($animalTreatments as $animalTreatment)
                                        <tr>

                                            <td class="text-center">{{ $animalTreatment->treatment_date }}</td>
                                            <td class="text-center">{{ $animalTreatment->farmAnimal->tag}}</td>
                                            <td class="text-center">{{ $animalTreatment->type }}</td>
                                            <td class="text-center">{{ $animalTreatment->product }}</td>
                                            <td class="text-center">{{ $animalTreatment->days_until_withdrawal }}</td>
                                            <td class="text-center">{{ $animalTreatment->booster_date }}</td>
                                            <td class="text-center">
                                                <a href="/animalTreatment/{{$animalTreatment->id}}/view"
                                                   class="btn btn-success mb-0"><i class="material-icons text-sm">visibility</i></a>
                                                | <a
                                                    onclick="openEditModal('/animalTreatment/' + {{$animalTreatment->id}} + '/find')"
                                                    class="btn btn-warning mb-0"><i
                                                        class="material-icons text-sm">edit</i></a> | <a
                                                    onclick="openDeleteModal('/animalTreatment/' + {{$animalTreatment->id}} + '/delete')"
                                                    class="btn btn-danger mb-0"><i
                                                        class="material-icons text-sm">delete</i></a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <div aria-hidden="true" aria-labelledby="addPigModal" class="modal fade" id="addPigModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-medium" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Add Treatment</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <form method="POST" action="{{ route('saveAnimalTreatment') }}" enctype="multipart/form-data">
                        @csrf <!-- Add this line to include the CSRF token -->

                        <div class="form-floating mb-3">
                            <select name="animal" id="animal" class="form-select">
                                @foreach ($animals as $animal)
                                    <option value="{{$animal->id}}"> {{$animal->tag}}</option>
                                @endforeach
                            </select>
                            <label for="animal">Animal</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select type</option>
                                <option value="Freshian">Freshian</option>
                                <option value="Hereford">Hereford</option>
                            </select>
                            <label for="type">type</label>
                        </div>


                        <!-- product  input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="product" id=product" required>
                                <option value="">Select product</option>
                                <option value="Milk">Milk</option>
                                <option value="Cheese">Cheese</option>
                            </select>
                            <label for="product">product</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="application_method" id=application_method" required>
                                <option value="">Select application_method</option>
                                <option value="Drug">Drug</option>
                                <option value="Injection">Injection</option>

                            </select>
                            <label for="application_method">Application method</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="days_until_withdrawal"
                                   name="days_until_withdrawal" required>
                            <label for="withdrawal_days">Withdrawal days</label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="technician" name="technician" required>
                            <label for="technician">Technician</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="dosage" name="dosage" required>

                            <label for="dosage">Dosage</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="treatment_date" name="treatment_date" required>
                            <label for="treatment_date">Treatment date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="body_part" id=body_part" required>
                                <option value="">Select body_part</option>
                                <option value="Hands">Hands</option>
                                <option value="Legs">Legs</option>

                            </select>
                            <label for="body_part">Body part </label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="booster_date" name="booster_date"
                                   required>
                            <label for="booster_date">Booster date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="total_cost" name="total_cost" required>
                            <label for="total_cost">Total cost</label>
                        </div>


                        <!-- Description input -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>


                        <!-- Submit button -->
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div aria-hidden="true" aria-labelledby="editPigModal" class="modal fade" id="editPigModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-medium" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Edit AnimalTreatment</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <form method="POST"
                          action="{{ isset($animalTreatment) ? route('animalTreatment.update', $animalTreatment->id) : '#' }}"
                          enctype="multipart/form-data">
                        @csrf <!-- Add this line to include the CSRF token -->
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <select name="animal" id="animal" class="form-select">
                                @foreach ($animals as $animal)
                                    <option value="{{$animal->id}}"> {{$animal->tag}}</option>
                                @endforeach
                            </select>
                            <label for="animal">Animal</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select type</option>
                                <option value="Freshian">Freshian</option>
                                <option value="Hereford">Hereford</option>
                            </select>
                            <label for="type">type</label>
                        </div>


                        <!-- product  input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="product" id=product" required>
                                <option value="">Select product</option>
                                <option value="Milk">Milk</option>
                                <option value="Cheese">Cheese</option>
                            </select>
                            <label for="product">product</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="application_method" id=application_method" required>
                                <option value="">Select application_method</option>
                                <option value="Drug">Drug</option>
                                <option value="Injection">Injection</option>

                            </select>
                            <label for="application_method">Application method</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="days_until_withdrawal"
                                   name="days_until_withdrawal" required>
                            <label for="withdrawal_days">Withdrawal days</label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="technician" name="technician" required>
                            <label for="technician">Technician</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="dosage" name="dosage" required>

                            <label for="dosage">Dosage</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="treatment_date" name="treatment_date" required>
                            <label for="treatment_date">Treatment date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="body_part" id=body_part" required>
                                <option value="">Select body_part</option>
                                <option value="Hands">Hands</option>
                                <option value="Legs">Legs</option>

                            </select>
                            <label for="body_part" Body part </label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="booster_date" name="booster_date"
                                   required>
                            <label for="booster_date">Booster date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="total_cost" name="total_cost" required>
                            <label for="total_cost">Total cost</label>
                        </div>


                        <!-- Description input -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>


                        <!-- Submit button -->
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete"
         aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="material-icons text-lg opacity-10">notifications</i>
                        <h4 class="text-gradient text-danger mt-4">Warning!</h4>
                        <p>Are you sure you want to delete this item.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-primary text-white ml-auto" data-bs-dismiss="modal">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-plugins></x-plugins>

</x-layout>

<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="animals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Animals"></x-navbars.navs.auth>
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
                                <h6 class="text-white text-capitalize ps-3">Animals table</h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a  onclick="openModal()" class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Animal</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Img</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tag</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date Acquired</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Category</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Breed</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Weight</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date Last Weighed</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Gender</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Description</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($animals as $animal)
                                        <tr>
                                            <td class="text-center"><img width="50" height="50" src="{{ asset('storage/'.$animal->img) }}"></td>
                                            <td class="text-center">{{ $animal->tag }}</td>
                                            <td class="text-center">{{ $animal->date_acquired }}</td>
                                            <td class="text-center">{{ $animal->farmAnimal->animal }}</td>
                                            <td class="text-center">{{ $animal->animalBreed->name }}</td>
                                            <td class="text-center">{{ $animal->weight }}</td>
                                            <td class="text-center">{{ $animal->date_last_weighed }}</td>
                                            <td class="text-center">{{ $animal->gender }}</td>
                                            <td class="text-center">{{ $animal->description }}</td>
                                            <td class="text-center">
                                                <a  href="/animal/{{$animal->id}}/view" class="btn btn-success mb-0"><i class="material-icons text-sm">visibility</i></a> | <a  onclick="openEditModal('/animal/' + {{$animal->id}} + '/find')" class="btn btn-warning mb-0"><i class="material-icons text-sm">edit</i></a> | <a  onclick="openDeleteModal('/animal/' + {{$animal->id}} + '/delete')" class="btn btn-danger mb-0"><i class="material-icons text-sm">delete</i></a>
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
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Add Animal</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <form method="POST" action="{{ route('saveAnimal') }}" enctype="multipart/form-data">
                        @csrf <!-- Add this line to include the CSRF token -->

                        <!-- Image input -->
                        <div class="mb-3">
                            <label for="img" class="form-label">Image</label>
                            <input type="file" class="form-control-file" id="img" name="img" required>
                        </div>

                        <!-- Tag input -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="tag" name="tag" required>
                            <label for="tag">Tag</label>
                        </div>

                        <!-- Date Acquired input -->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_acquired" name="date_acquired" required>
                            <label for="date_acquired">Date Acquired</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="category" id="category" required>
                                <option value="">Select Category</option>
                                <!-- Add options dynamically based on your breeds data -->
                                @foreach ($animalCategories as $animalCategory)
                                    <option value="{{ $animalCategory->id }}">{{ $animalCategory->animal }}</option>
                                @endforeach
                            </select>
                            <label for="category">Category</label>
                        </div>

                        <!-- Breed input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="breed" id="breed" required>
                                <option value="">Select Breed</option>
                                <!-- Add options dynamically based on your breeds data -->
                                @foreach ($breeds as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->name }}</option>
                                @endforeach
                            </select>
                            <label for="breed">Breed</label>
                        </div>

                        <!-- Weight input -->
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" required>
                            <label for="weight">Weight</label>
                        </div>

                        <!-- Date Last Weighed input -->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_last_weighed" name="date_last_weighed" required>
                            <label for="date_last_weighed">Date Last Weighed</label>
                        </div>

                        <!-- Gender input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label for="gender">Gender</label>
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

    <div aria-hidden="true" aria-labelledby="editPigModal" class="modal fade" id="editPigModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-medium" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Edit Animal</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <form method="POST" action="{{ isset($animal) ? route('animal.update', $animal->id) : '#' }}" enctype="multipart/form-data">
                        @csrf <!-- Add this line to include the CSRF token -->
                        @method('PUT')
                        <!-- Image input -->
                        <div class="mb-3">
                            <label for="img" class="form-label">Image</label>
                            <input type="file" class="form-control-file" id="edit_img" name="img" >
                        </div>

                        <!-- Tag input -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editTag" name="tag" required>
                            <label for="tag">Tag</label>
                        </div>

                        <!-- Date Acquired input -->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="edit_date_acquired" name="date_acquired" required>
                            <label for="date_acquired">Date Acquired</label>
                        </div>

                        <!-- Breed input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="category" id="edit_category" required>
                                <option value="">Select Category</option>
                                <!-- Add options dynamically based on your breeds data -->
                                @foreach ($animalCategories as $animalCategory)
                                    <option value="{{ $animalCategory->id }}">{{ $animalCategory->animal }}</option>
                                @endforeach
                            </select>
                            <label for="category">Category</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="breed" id="edit_breed" required>
                                <option value="">Select Breed</option>
                                <!-- Add options dynamically based on your breeds data -->
                                @foreach ($breeds as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->name }}</option>
                                @endforeach
                            </select>
                            <label for="breed">Breed</label>
                        </div>

                        <!-- Weight input -->
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="edit_weight" name="weight" required>
                            <label for="weight">Weight</label>
                        </div>

                        <!-- Date Last Weighed input -->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="edit_date_last_weighed" name="date_last_weighed" required>
                            <label for="date_last_weighed">Date Last Weighed</label>
                        </div>

                        <!-- Gender input -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="edit_gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>

                        <!-- Description input -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="edit_description" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>

                        <!-- Submit button -->
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                {{--<div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-delete">Your attention is required</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>--}}
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="material-icons text-lg opacity-10">notifications</i>
                        <h4 class="text-gradient text-danger mt-4">Warning!</h4>
                        <p>Are you sure you want to delete this item.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  id="confirmDelete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-primary text-white ml-auto" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <x-plugins></x-plugins>

</x-layout>

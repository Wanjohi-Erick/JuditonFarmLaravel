<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="view-animal_treatment"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='View AnimalTreatment'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                 style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Treatment Information</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status'))
                            <div class="row">
                                <div class="alert alert-success alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                        @endif
                        <form method='POST' action='{{ route('user-profile') }}'>
                            @csrf
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Tag</label>
                                    <input type="text" name="tag" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->farmAnimal->tag }}' disabled>
                                    @error('email')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">type</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2"
                                               value='{{ $animalsTreatment->type }}' disabled>
                                        @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">product</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2"
                                               value='{{ $animalsTreatment->product }}' disabled>
                                        @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label class="form-label">application_method</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->application_method }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Withrawal days</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->type }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">technician</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->technician }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">dosage</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->dosage }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">treatment_date</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->treatment_date }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">body_part</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->body_part }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">booster_date</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->booster_date }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">total_cost</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                           value='{{ $animalsTreatment->total_cost }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="floatingTextarea2">Description</label>
                                    <textarea class="form-control border border-2 p-2"
                                              placeholder=" Say something about yourself" id="floatingTextarea2"
                                              name="about"
                                              rows="4" cols="50"
                                              disabled>{{ $animalsTreatment->description }}</textarea>
                                    @error('about')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>

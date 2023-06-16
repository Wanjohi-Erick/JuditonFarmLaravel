<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="view-animal"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='View Animal'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative align-self-center">
                            <img src="{{ asset('storage/'.$animals->img) }}" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Animal Information</h6>
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
                        @if (Session::has('demo'))
                                <div class="row">
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('demo') }}</span>
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
                                    <input type="email" name="email" class="form-control border border-2 p-2" value='{{ $animals->tag }}' disabled>
                                    @error('email')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Date Acquired</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2" value='{{ $animals->date_acquired }}' disabled>
                                    @error('name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="phone" class="form-control border border-2 p-2" value='{{ $animals->farmAnimal->animal }}' disabled>
                                    @error('phone')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Breed</label>
                                    <input type="text" name="location" class="form-control border border-2 p-2" value='{{ $animals->animalBreed->name }}' disabled>
                                    @error('location')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="floatingTextarea2">Description</label>
                                    <textarea class="form-control border border-2 p-2"
                                        placeholder=" Say something about yourself" id="floatingTextarea2" name="about"
                                        rows="4" cols="50" disabled>{{ $animals->description }}</textarea>
                                        @error('about')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Weight tracking table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Measured</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Weight</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Weight Gained</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($weights as $weight)
                                        <tr>
                                            <td class="text-center">{{ $weight-> date_measured}}</td>
                                            <td class="text-center">{{ $weight-> weight}}</td>
                                            <td class="text-center">{{ $weight-> weight_gained}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line" class="chart-canvas"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 "> Timely Weight Progress </h6>
                            <p class="text-sm">(<span id="weight-increase" class="font-weight-bolder">+0%</span>) increase in weight.</p>
                            <hr class="dark horizontal">
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p id="last-updated" class="mb-0 text-sm"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
    @push('js')
        <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
        <script>

            // Get the weights data from the PHP variable $weights
            var weightData = @json($weights);

            // Calculate sales increase
            var initialWeight = weightData[weightData.length - 2].weight; // Assuming the second last weight is the initial weight
            var latestWeight = weightData[weightData.length - 1].weight; // Assuming the last weight is the latest weight
            var salesIncrease = ((latestWeight - initialWeight) / initialWeight * 100).toFixed(2) + '%';

            // Get the last measured time
            var lastMeasuredTime = weightData[weightData.length - 1].date_measured;

            // Update the content of the elements
            document.getElementById('weight-increase').textContent = salesIncrease;
            document.getElementById('last-updated').textContent = 'updated ' + lastMeasuredTime;


            // Extract the date measured and weight values from the weights data
            var labels = weightData.map(function(item) {
                return item.date_measured;
            });

            var data = weightData.map(function(item) {
                return item.weight;
            });

            // Create a new Chart.js line chart
            new Chart(document.getElementById("chart-line"), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Weight',
                        data: data,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date Measured'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Weight'
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-layout>

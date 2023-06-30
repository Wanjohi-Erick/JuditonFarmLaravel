<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="items"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Items"></x-navbars.navs.auth>
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
                                <h6 class="text-white text-capitalize ps-3">Items table</h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a onclick="openModal()" class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Item</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="itemsTable">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            #
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Stock at Hand
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Group
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Reorder Level
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $serial = 1;
                                    @endphp
                                    @foreach ($items as $item)

                                        @php
                                            $status = ($item->amount < $item->reorder_level) ? "Insufficient Stock" : "Sufficient Stock";
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $serial }}</td>
                                            <td class="text-center">{{ $item->item_name }}</td>
                                            <td class="text-center">{{ $item->itemStock->amount }}</td>
                                            <td class="text-center">{{ $item->item_group }}</td>
                                            <td class="text-center">{{ $item->reorder_level }}</td>
                                            <td class="text-center">{{ $status }}</td>
                                            <td class="text-center">
                                                <a href="/item/{{$item->id}}/view" class="btn btn-success mb-0"><i
                                                        class="material-icons text-sm">visibility</i></a> | <a
                                                    onclick="openEditModal('/item/' + {{$item->id}} + '/find')"
                                                    class="btn btn-warning mb-0"><i
                                                        class="material-icons text-sm">edit</i></a> | <a
                                                    onclick="openDeleteModal('/item/' + {{$item->id}} + '/delete')"
                                                    class="btn btn-danger mb-0"><i
                                                        class="material-icons text-sm">delete</i></a>
                                            </td>
                                        </tr>
                                        @php($serial++)
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
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Add Item</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="content">
                        <div class="container-fluid">


                            <div class="row" style="margin-left:-33px;margin-right:-33px;">
                                <div class="col-sm-12 table-responsive">
                                    <div class="w3-container">
                                        <form method="POST" action="{{ route('saveItem') }}"
                                              enctype="multipart/form-data">
                                            @csrf <!-- Add this line to include the CSRF token -->
                                            <div id="Londonstudents" class="w3-container  city w3-animate-left">
                                                <div class="row" style="margin-right:-23px;margin-left:-25px">
                                                    <div class="col-lg-4 d-flex align-items-stretch" id="firstdiv">
                                                        <div class="card w-100" id="left">

                                                            <div
                                                                class="card-header card-header-tabs card-header-primary">
                                                                <div class="bg-gradient-primary border-radius-lg py-2">
                                                                    <h4 class="card-title ps-2">Main Details</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <div class="input-group input-group-outline my-3">
                                                                    <label class="form-label">SKU</label>
                                                                    <input id="sku" name="sku" class="form-control"
                                                                           type="text" required>
                                                                </div>
                                                                <div class="input-group input-group-outline my-3">
                                                                    <label class="form-label">Name</label>
                                                                    <input name="itemName" class="form-control"
                                                                           type="text"
                                                                           required>
                                                                </div>

                                                                <div class="input-group input-group-static my-3">
                                                                    <select name="uom" type="select"
                                                                            class="form-select">
                                                                        <option value="selected">UOM</option>
                                                                        <option value="Pieces">Pieces</option>
                                                                        <option value="Bags">Bags</option>
                                                                        <option value="Kilos">Kilos</option>
                                                                    </select>
                                                                </div>

                                                                <div class="input-group input-group-outline my-3">
                                                                    <input name="itemPrice" class="form-control"
                                                                           type="text" placeholder=" " required>
                                                                    <label class="form-label">Item Price</label>
                                                                </div>

                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           name="returnable" id="returnable">
                                                                    <label class="custom-control-label"
                                                                           for="returnable">Returnable
                                                                        Item</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 d-flex align-items-stretch" id="firstdiv">


                                                        <div class="card w-100" id="left">

                                                            <div
                                                                class="card-header card-header-tabs card-header-primary">
                                                                <div class="bg-gradient-primary border-radius-lg py-2">
                                                                    <h4 class="card-title ps-2">Other Details</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <div class="input-group input-group-static my-3">
                                                                    <select name="itemCategory" type="select"
                                                                            class="form-select">
                                                                        <option value="selected">Select a category
                                                                        </option>
                                                                        <option value="permanent">Permanent</option>
                                                                        <option value="consumable">Consumable
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                    <select id="itemGroup" name="itemGroup"
                                                                            class="form-select mb-3"
                                                                            style="width: 197px;">
                                                                        <option disabled selected>Pick a group</option>
                                                                        @foreach($itemGroups as $itemGroup)
                                                                            <option value="{{$itemGroup->id}}">{{$itemGroup->group_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button id="newButton" class="btn btn-primary ms-2"
                                                                            onclick="openAddGroupModal()">New
                                                                    </button>
                                                                </div>

                                                                <div class="input-group input-group-outline my-3">
                                                                    <input name="openingStock" class="form-control"
                                                                           type="text" placeholder=" " required>
                                                                    <label class="form-label">Opening Stock</label>
                                                                </div>

                                                                <div class="input-group input-group-outline my-3">
                                                                    <input name="reorderLevel" class="form-control"
                                                                           type="text" placeholder=" " required>
                                                                    <label class="form-label">Reorder Level</label>
                                                                </div>

                                                                <select id="preferredVendor" name="preferredVendor" class="form-select mb-3">
                                                                    <option disabled selected>Pick the vendor</option>
                                                                    @foreach($vendors as $vendor)
                                                                        <option value="{{$vendor->id}}">{{$vendor->company}}</option>
                                                                    @endforeach
                                                                </select>

                                                                <button id="uploadButton" class="btn btn-primary">Upload
                                                                    Image
                                                                </button>
                                                            </div>

                                                        </div>


                                                    </div>
                                                    <div class="col-lg-4 d-flex align-items-stretch" id="firstdiv">


                                                        <div class="card w-100" id="left">

                                                            <div
                                                                class="card-header card-header-tabs card-header-primary">
                                                                <div class="bg-gradient-primary border-radius-lg py-2">
                                                                    <h4 class="card-title ps-2">Cover Photo</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <input type="file" id="imageInput" accept="image/*"
                                                                       style="display:none">
                                                                <input type="hidden" name="imageUrl" id="imageUrl">
                                                                <div id="imageView"
                                                                     style="width: 100%; height: 300px; border: 1px solid black; background-color: lightgray;"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" value="Save" class="btn btn-primary">
                                        </form>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <div style="z-index: 11000;" aria-hidden="true" aria-labelledby="newTagModalLabel" class="modal fade" id="addGroupModal" role="dialog"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="newTagModalLabel">New Group</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-target="#addGroupModal" data-bs-toggle="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/api/inv/addItemGroup" method="post">
                    <div class="modal-body">
                        <div class="floating-form-group mb-3">
                            <input id="itemGroupEdit" class="floating-form-control" name="groupName" placeholder=" " type="text">
                            <label class="label1" for="itemGroupEdit">Item Group</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal" type="submit">Add</button>
                        <button class="btn bg-gradient-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete"
         aria-hidden="true">
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
                    <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-primary text-white ml-auto" data-bs-dismiss="modal">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-plugins></x-plugins>

</x-layout>

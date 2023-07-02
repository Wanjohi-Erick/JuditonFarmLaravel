<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="items"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Items"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div id="successMessage" class="alert alert-success" style="display: none;"></div>
            <div id="failureMessage" class="alert alert-danger" style="display: none;"></div>
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Items table</h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a onclick="openRestockModal()" class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Restock Item</a>
                            <a onclick="openModal()" class="btn bg-gradient-dark mb-0 ms-3" href="javascript:;"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Item</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="itemsTable">
                                    <thead class="thead-light">
                                    <tr>
                                       {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            #
                                        </th>--}}
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
                                    <script>
                                        $(document).ready(function () {
                                            $.get('/getAllItems', function (data) {
                                                $('#itemsTable').DataTable({
                                                    responsive: true,
                                                    "data": data, "columns": [
                                                        {
                                                        "data": "item_name", "render": function (data, type, row, meta) {
                                                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                                                        }, "createdCell": function (td, cellData, rowData, row, col) {
                                                            $(td).addClass('align-middle text-center text-sm');
                                                        }
                                                    }, {
                                                        "data": "item_stock[0].amount", "render": function (data, type, row, meta) {
                                                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                                                        }, "createdCell": function (td, cellData, rowData, row, col) {
                                                            $(td).addClass('align-middle text-center text-sm');
                                                        }
                                                    }, {
                                                        "data": "item_group", "render": function (data, type, row, meta) {
                                                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                                                        }, "createdCell": function (td, cellData, rowData, row, col) {
                                                            $(td).addClass('align-middle text-center text-sm');
                                                        }
                                                    }, {
                                                        "data": "reorder_level", "render": function (data, type, row, meta) {
                                                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                                                        }, "createdCell": function (td, cellData, rowData, row, col) {
                                                            $(td).addClass('align-middle text-center text-sm');
                                                        }
                                                    }, {
                                                            "data": "item_stock[0].amount",
                                                            "render": function (data, type, row, meta) {
                                                                // Compare the values and apply custom styling
                                                                var comparisonResult = data >= row.reorder_level ? 'text-success' : 'text-danger';
                                                                var status = data >= row.reorder_level ? 'Sufficient Stock' : 'Insufficient Stock';
                                                                return '<p class="text-xs ' + comparisonResult + ' mb-0">' + status + '</p>';
                                                            },
                                                            "createdCell": function (td, cellData, rowData, row, col) {
                                                                $(td).addClass('align-middle text-center text-sm');
                                                            }
                                                        }, {
                                                        "data": "id", "render": function (data, type, row, meta) {
                                                            return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="editItem('${data}')" class="dropdown-item" href="javascript:;">Edit</a>
                                            <a onclick="deleteItem('/item/${data}/delete')" class="dropdown-item" href="javascript:;">Delete</a>
                                         </div>
                                            `;
                                                        }, "createdCell": function (td, cellData, rowData, row, col) {
                                                            $(td).addClass('align-middle text-center text-sm');
                                                        }
                                                    }]
                                                })
                                            });
                                        });
                                    </script>
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                        <form method="POST" id="addItemForm"
                                              enctype="multipart/form-data">
                                            @csrf <!-- Add this line to include the CSRF token -->
                                            <div id="Londonstudents" class="w3-container  city w3-animate-left">
                                                <div class="row" style="margin-right:-23px;margin-left:-25px">
                                                    <div class="col-lg-6 d-flex align-items-stretch" id="firstdiv">
                                                        <div class="card w-100" id="left">
                                                            <div class="card-body table-responsive">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 d-flex align-items-stretch" id="firstdiv">


                                                        <div class="card w-100" id="left">
                                                            <div class="card-body table-responsive">
                                                                <div class="d-flex align-items-center">
                                                                    <select id="itemGroup" name="itemGroup" class="form-select my-3" style="width: 197px;">
                                                                        <option disabled selected>Pick a group</option>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                getGroups().then(function (response) {
                                                                                    $.each(response, function (index, data) {
                                                                                        let option = $('<option value="' + data.group_name + '">' + data.group_name + '</option>');
                                                                                        $('#addPigModal #itemGroup').append(option);
                                                                                    })
                                                                                }).catch(function (error) {
                                                                                    console.log(error);
                                                                                })
                                                                            })
                                                                        </script>
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
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            getVendors().then(function (response) {
                                                                                $.each(response, function (index, data) {
                                                                                    let option = $('<option value="' + data.id + '">' + data.company + '</option>');
                                                                                    $('#addPigModal #preferredVendor').append(option);
                                                                                })
                                                                            }).catch(function (error) {
                                                                                console.log(error);
                                                                            })
                                                                        })
                                                                    </script>
                                                                </select>
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

    <div aria-hidden="true" aria-labelledby="restockModal" class="modal fade" id="restockModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="settingsModalLabel">Restock Item</h5>
                    <button aria-label="Close" class="btn-close text-dark" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="restockItemForm" enctype="multipart/form-data">
                        @csrf <!-- Add this line to include the CSRF token -->
                        <div class="input-group input-group-static my-3">
                            <select name="item" id="item" type="select" class="form-select">
                                <option value="selected">Select Item</option>
                                <script>
                                    $(document).ready(function() {
                                        getItems().then(function (response) {
                                            $.each(response, function (index, data) {
                                                let option = $('<option value="' + data.id + '">' + data.item_name + '</option>');
                                                $('#restockModal #item').append(option);
                                            })
                                        }).catch(function (error) {
                                            console.log(error);
                                        })
                                    })
                                </script>
                            </select>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <input name="quantity" class="form-control"
                                   type="text" placeholder=" " required>
                            <label class="form-label">Quantity</label>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <input name="itemPrice" class="form-control"
                                   type="text" placeholder=" " required>
                            <label class="form-label">Item Price</label>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <input name="transaction_reference" class="form-control"
                                   type="text" placeholder=" " required>
                            <label class="form-label">Transaction Reference</label>
                        </div>

                        <select id="preferredVendor" name="preferredVendor" class="form-select mb-3">
                            <option disabled selected>Pick the vendor</option>
                            <script>
                                $(document).ready(function() {
                                    getVendors().then(function (response) {
                                        $.each(response, function (index, data) {
                                            let option = $('<option value="' + data.id + '">' + data.company + '</option>');
                                            $('#restockModal #preferredVendor').append(option);
                                        })
                                    }).catch(function (error) {
                                        console.log(error);
                                    })
                                })
                            </script>
                        </select>

                        <input class="btn btn-primary" type="submit" value="Restock">
                    </form>
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
                <form id="addGroupForm" method="post">
                    @csrf
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
                <div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-delete">Your attention is required</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
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

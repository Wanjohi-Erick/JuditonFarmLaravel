let selectedIssuedItem = null;
function setActiveNav(clickedElement) {
    // remove active class from all nav items
    const navItems = document.querySelectorAll('.nav-link');
    navItems.forEach(navItem => {
        navItem.classList.remove('active');
        navItem.classList.remove('bg-gradient-primary');
    });

    // add active class to clicked nav item
    clickedElement.classList.add('active');
    clickedElement.classList.add('bg-gradient-primary');
}

function getGroups() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/api/inv/getAllItemGroups',
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}

function getItems() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/api/inv/getAllItems',
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}

$(document).ready(function () {
    $.ajax({
        url: '/api/inv/initDashboard',
        method: 'GET',
        contentType: 'application/json'
    }).done(function(response) {
        console.log(response);
        $('#items_held').text(response.items_held);
        $('#non_refundable').text(response.non_refundable);
        $('#to_be_invoiced').text(response.to_be_invoiced);
        $('#to_be_delivered').text(response.to_be_delivered);
        $('#quantity_to_be_received').text(response.to_be_delivered)
        $('#quantity_in_hand').text(response.total_amount);
        $('#all_item_groups').text(response.all_item_groups);
        $('#all_items').text(response.all_items);
        $('#low_stock_items').text(response.reorder_status);
        var checkedOption = $('input[name=radioOptions]:checked').attr('id');

        if (checkedOption === 'radioMonth') {
            console.log("The 'This Month' option is checked");
            $('#this_month_purchase_order_quantity').text(response.this_month_purchase_order_quantity);
            $('#this_month_purchase_order_total').text(response.this_month_purchase_order_total);
        } else if (checkedOption === 'radioYear') {
            console.log("The 'This Year' option is checked");
            $('#this_month_purchase_order_quantity').text(response.this_year_purchase_order_quantity);
            $('#this_month_purchase_order_total').text(response.this_year_purchase_order_total);
        } else {
            console.log("No radio button is checked");
        }
        $('#fastestMovingItemsTable').DataTable({
            dom: 'r',
            responsive: true,
            "data": response.fastest_moving_items, "columns": [{
                "data": "image", "render": function (data, type, row, meta) {
                    return '<div class="d-flex px-2 py-1">\n' + ' <div>\n' + ' <img src="' + data + '" class="avatar avatar-sm me-3 border-radius-lg" alt="">\n' + '</div>\n' + '</div>';
                }, "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).addClass('align-middle text-center text-sm');
                }
            }, {
                "data": "item_name", "render": function (data, type, row, meta) {
                    return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                }, "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).addClass('align-middle text-center text-sm');
                }
            }, {
                "data": "counts", "render": function (data, type, row, meta) {
                    return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                }, "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).addClass('align-middle text-center text-sm');
                }
            }]
        })
        $('input[name=radioOptions]').change(function() {
            var checkedOption = $('input[name=radioOptions]:checked').attr('id');

            if (checkedOption === 'radioMonth') {
                console.log("The 'This Month' option is checked");
                $('#this_month_purchase_order_quantity').text(response.this_month_purchase_order_quantity);
                $('#this_month_purchase_order_total').text(response.this_month_purchase_order_total);
            } else if (checkedOption === 'radioYear') {
                console.log("The 'This Year' option is checked");
                $('#this_month_purchase_order_quantity').text(response.this_year_purchase_order_quantity);
                $('#this_month_purchase_order_total').text(response.this_year_purchase_order_total);
            }
        });
    }).fail(function(fail) {
        console.log(fail);
    })
})

function loadNewGroup(event) {
    event.preventDefault();
    console.log("opened add group modal");
    $('#addItemModal').modal('show');
}

function openItemsFragment() {
    $.get('items').done(function (fragment) {
        $('#pageName').text("Items");
        $('#pageNameH6').text("Items");
        $.ajax({
            url: '/api/inv/getAllItems', contentType: 'application/json'
        }).done(function (response) {
            $('#itemsTable').DataTable({
                responsive: true, "data": response, "columns": [{
                    "data": "image", "render": function (data, type, row, meta) {
                        return '<div class="d-flex px-2 py-1">\n' + ' <div>\n' + ' <img src="' + data + '" class="avatar avatar-sm me-3 border-radius-lg" alt="">\n' + '</div>\n' + '</div>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "itemName", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "itemId", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "units", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "itemGroup", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "reorderLevel", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "itemsStatus", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "itemId", "render": function (data, type, row, meta) {
                        return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="editItem('${data}')" class="dropdown-item" href="javascript:;">Edit</a>
                                            <a onclick="deleteItem('/api/inv/deleteItem/${data}')" class="dropdown-item" href="javascript:;">Delete</a>
                                         </div>
                                            `;
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function addItemModalLaunch() {
    getGroups().then(function (response) {
        $.each(response, function (index, data) {
            let option = $('<option value="' + data.groupName + '">' + data.groupName + '</option>');
            $('#addItemModal #itemGroup').append(option);
        })
    }).catch(function (error) {
        console.log(error);
    })
    $('#addItemModal').modal('show');
    document.getElementById("uploadButton").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent form submission
        console.log("clicked");
        document.getElementById("imageInput").click();
    });
}

function openAdjustmentFragment() {
    $.get('inventoryAdjustment').done(function (fragment) {
        $('#pageName').text("Items");
        $('#pageNameH6').text("Items");
        $.ajax({
            url: '/api/inv/getAllAdjustments', contentType: 'application/json'
        }).done(function (response) {
            $('#itemsAdjustmentTable').DataTable({
                responsive: true, "data": response, "columns": [{
                    "data": "item", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data.itemName + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "date", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "reason", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "description", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "adjustmentType", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "adjustedBy", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "", "render": function (data, type, row, meta) {
                        return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="viewBook('${row.code}')" class="dropdown-item" href="javascript:;">View Book</a>
                                            <a onclick="editBookModalLaunch('${row.code}')" class="dropdown-item" href="javascript:;">Edit Book</a>
                                            <a onclick="deleteBook('${row.code}')" class="dropdown-item" href="javascript:;">Delete Book</a>
                                            <a onclick="markAsLost('${row.code}')" class="dropdown-item" href="javascript:;">Mark as Available</a>
                                         </div>
                                            `;
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

$(document).ready(function() {
    $('#adjustmentType').on('change', function() {
        let adjustmentDiv = $('#valueOrQuantity');
        let valueOrQuantity = $('#adjustmentType option:selected').val();
        console.log(valueOrQuantity);
        let quantity = "<div class=\"card w-100\" id=\"left\">\n" +
            "                                            <div class=\"card-body table-responsive\">\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">Quantity</label>\n" +
            "                                                    <input name=\"quantity\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">New Quantity</label>\n" +
            "                                                    <input name=\"newQuantity\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">Adjusted</label>\n" +
            "                                                    <input name=\"adjusted\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "                                            </div>\n" +
            "                                        </div>";

        let value = "<div class=\"card w-100\" id=\"left\">\n" +
            "                                            <div class=\"card-body table-responsive\">\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">Value</label>\n" +
            "                                                    <input name=\"value\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">New Value</label>\n" +
            "                                                    <input name=\"newValue\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "\n" +
            "                                                <div class=\"input-group input-group-dynamic mb-3\">\n" +
            "                                                    <label class=\"form-label\">Adjusted</label>\n" +
            "                                                    <input name=\"adjusted\" class=\"multisteps-form__input form-control\" type=\"number\" />\n" +
            "                                                </div>\n" +
            "                                            </div>\n" +
            "                                        </div>";
        adjustmentDiv.clear();
        if (valueOrQuantity === "Value Adjustment") {
            adjustmentDiv.append(value);
        } else {
            adjustmentDiv.append(quantity);
        }
    })
})

function addAdjustmentModalLaunch() {
    getItems().then(function (response) {
        $.each(response, function (index, data) {
            let option = $('<option value="' + data.itemId + '">' + data.itemName + '</option>');
            $('#addAdjustmentModal #item').append(option);
        })
    }).catch(function (error) {
        console.log(error);
    })
    $('#addAdjustmentModal').modal('show');
}



function openVendorsFragment() {
    $.get('vendors').done(function (fragment) {
        $('#pageName').text("Vendors");
        $('#pageNameH6').text("Vendors");
        $.ajax({
            url: '/api/inv/getAllVendors', contentType: 'application/json'
        }).done(function (response) {
            $('#vendorsTable').DataTable({
                responsive: true, "data": response, "columns": [
                    {
                        "data": "company", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "contactName", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "itemGroup", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "phone", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "email", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "id", "render": function (data, type, row, meta) {
                            return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="editVendor('${data}')" class="dropdown-item" href="javascript:;">Edit</a>
                                            <a onclick="deleteItem('/api/inv/deleteVendor/${data}')" class="dropdown-item" href="javascript:;">Delete</a>
                                         </div>
                                            `;
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function addVendorModalLaunch() {
    getGroups().then(function (response) {
        $.each(response, function (index, data) {
            let option = $('<option value="' + data.groupName + '">' + data.groupName + '</option>');
            $('#addVendorModal #itemGroup').append(option);
        })
    }).catch(function (error) {
        console.log(error);
    })
    $('#addVendorModal').modal('show');
}

function openRequisitionFragment() {
    $.get('requisition').done(function (fragment) {
        $('#pageName').text("Requisition");
        $('#pageNameH6').text("Requisition");
        $.ajax({
            url: '/api/inv/getAllRequisitions', contentType: 'application/json'
        }).done(function (response) {
            $('#requisitionTable').DataTable({
                responsive: true, "data": response, "columns": [{
                    "data": "requestedOn", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "items", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "department", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "requestedBy", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "cost", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "status", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "id", "render": function (data, type, row, meta) {
                        return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="viewRequisition('${data}')" class="dropdown-item" href="javascript:;">View Details</a>
                                            <a onclick="print('/api/inv/printRequisitionForm/${data}')" class="dropdown-item" href="javascript:;">Print</a>
                                         </div>
                                            `;
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function addRequisitionModalLaunch() {
    $('#addRequisitionModal').modal('show');
}

function openPurchaseOrdersFragment() {
    $.get('purchaseOrders').done(function (fragment) {
        $('#pageName').text("Purchase Orders");
        $('#pageNameH6').text("Purchase Orders");
        $.ajax({
            url: '/api/inv/getAllPurchaseOrders', contentType: 'application/json'
        }).done(function (response) {
            $('#purchaseOrdersTable').DataTable({
                responsive: true, "data": response, "columns": [{
                    "data": "createdOn", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "expectedDate", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "items", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "comments", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "cost", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "status", "render": function (data, type, row, meta) {
                        return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }, {
                    "data": "id", "render": function (data, type, row, meta) {
                        return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="viewPurchaseOrder('${data}')" class="dropdown-item" href="javascript:;">View Details</a>
                                            <a onclick="print('/api/inv/printPurchaseOrder/${data}')" class="dropdown-item" href="javascript:;">Print</a>
                                         </div>
                                            `;
                    }, "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).addClass('align-middle text-center text-sm');
                    }
                }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function openAssetManagementFragment() {
    $.get('assetManagement').done(function (fragment) {
        $('#pageName').text("Asset Management");
        $('#pageNameH6').text("Asset Management");
        $.ajax({
            url: '/api/inv/getAllAssets', contentType: 'application/json'
        }).done(function (response) {
            $('#assetsTable').DataTable({
                responsive: true, "data": response, "columns": [
                    {
                        "data": "serial", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "name", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "type", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "description", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "openingBalance", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "status", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "id", "render": function (data, type, row, meta) {
                            return `
                                          <button class="btn btn-link text-secondary mb-0" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                            <a onclick="viewAsset('${data}')" class="dropdown-item" href="javascript:;">View Details</a>
                                            <a onclick="deleteItem('/api/inv/undoLastDepreciation/${data}')" class="dropdown-item" href="javascript:;">Undo Last Depreviation</a>
                                            <a onclick="deleteItem('/api/inv/deleteAsset/${data}')" class="dropdown-item" href="javascript:;">Delete</a>
                                         </div>
                                            `;
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function addAssetManagementModalLaunch() {
    getGroups().then(function (response) {
        $.each(response, function (index, data) {
            let option = $('<option value="' + data.groupName + '">' + data.groupName + '</option>');
            $('#addAssetModal #itemGroup').append(option);
        })
    }).catch(function (error) {
        console.log(error);
    })
    $('#addAssetModal').modal('show');
}

$(document).ready(function () {
    const imageView = document.getElementById('imageView');
    const imageInput = document.getElementById('imageInput');
    imageInput.addEventListener('change', (event) => {
        console.log(imageInput);
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            const image = new Image();
            image.src = reader.result;
            $('#imageUrl').val(reader.result);
            console.log(reader.result);
            image.onload = () => {
                const width = image.width;
                const height = image.height;
                const aspectRatio = width / height;
                let newWidth = 300;
                let newHeight = 300;
                if (width > height) {
                    newHeight = newWidth / aspectRatio;
                } else {
                    newWidth = newHeight * aspectRatio;
                }
                imageView.style.backgroundImage = `url(${reader.result})`;
                imageView.style.backgroundSize = `${newWidth}px ${newHeight}px`;
            };
        };
        uploadFile(file);
    });

    function uploadFile(file) {
        console.log("upload");
        var myFormData = new FormData();
        myFormData.append('pictureFile', file);
        myFormData.append('morepath', "inventory_images");

        $.ajax({
            url: "/upload",
            type: "POST",
            data: myFormData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (res) {
                console.log(res);
                var obj = JSON.parse(res);
                console.log(obj);
                document.getElementById("imageUrl").value = obj['path'];

                console.log(obj['querystatus']);

                $(function () {
                    $("#messageid").html(obj['querystatus']);
                    $('#myModal').modal('show');
                    setTimeout(function () {
                        $('#myModal').modal('hide');
                    }, 1500);
                });

            },
            error: function (err) {
                $(function () {
                    $("#change-me").html(err);
                    $('#myModalError').modal('show');
                });
            }
        });


    }
})

function addItem() {
    var code = $('#editBookModal input[name="code"]').val();
    var title = $('#editBookModal input[name="title"]').val();
    var author = $('#editBookModal input[name="author"]').val();
    var publisher = $('#editBookModal input[name="publisher"]').val();
    var price = $('#editBookModal input[name="price"]').val();
    var category = $('#editBookModal [name="category"]').val();
    var classes = $('#editBookModal [name="classes"]').val();
    var condition = $('#editBookModal [name="condition"]').val();
    var subject = $('#editBookModal input[name="subject"]').val();
    var other_notes = $('#editBookModal [name="other_notes"]').val();
    var imageInput = $('#imageUrl').val();

    var bookObject;

    bookObject = {
        code: code,
        title: title,
        author: author,
        publisher: publisher,
        price: price,
        category: category,
        classes: classes,
        condition: condition,
        subject: subject,
        other_notes: other_notes,
        imageInput: imageInput
    };

    $.ajax({
        url: '/api/lib/updateBook',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(bookObject)
    }).done(function (response) {
        $('#editBookModal').modal('hide');
        console.log(response);
        var message = JSON.parse(response);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>" + message.response + "</p>");
        $('#infoModal').modal('show');
        $('#infoModal #confirmOk').click(function () {
            openBooksManagement();
        })
    }).fail(function (response) {
        console.log(response);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>An unexpected error occurred</p>");
        $('#infoModal').modal('show');
    })
}

function deleteItem(url) {
    $('#myModaldelete').modal('show');
    $('#myModaldelete #confirmdeletebutt').on('click', function() {
        $('#myModaldelete').modal('hide');
        $.ajax({
            url: url,
            method: 'GET',
            contentType: 'application/json'
        }).done(function (response) {
            $('#infoModal .modal-body').empty();
            $('#infoModal .modal-body').append(response.response);
            $('#infoModal').css('z-index', 10510);
            $('#infoModal').modal('show');
        }).fail(function(fail) {
            console.log(fail);
        })
    })
}

function openBillsFragment() {
    $.get('bills').done(function (fragment) {
        $('#pageName').text("Bills");
        $('#pageNameH6').text("Bills");
        $.ajax({
            url: '/api/inv/getAllBills', contentType: 'application/json'
        }).done(function (response) {
            $('#billsTable').DataTable({
                responsive: true, "data": response, "columns": [
                    {
                        "data": "billdate", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "name", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "amt", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "paid", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "pending", "render": function (data, type, row, meta) {
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }, {
                        "data": "status", "render": function (data, type, row, meta) {
                            if (data === "Not Paid") {
                                $(row).css('background-color', 'red');
                            } else if (data === "Paid") {
                                $(row).css('background-color', 'green');
                            } else if (data === "Partially Paid") {
                                $(row).css('background-color', 'blue');
                            }
                            return '<p class="text-xs text-secondary mb-0">' + data + '</p>';
                        }, "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).addClass('align-middle text-center text-sm');
                        }
                    }]
            })
        }).fail(function () {
            console.log(fail);
        })
        $('#output').replaceWith(fragment);
    })
}

function issueItems() {
    $.post('issueItems').done(function (fragment) {
        $('#pageName').text("Issue Items");
        $('#pageNameH6').text("Issue Items");
        $('#output').replaceWith(fragment);
        $('#pendingIssueTable').DataTable({
            responsive: true
        });
    })
}

function returnItems() {
    $.post('returnItems').done(function (fragment) {
        $('#pageName').text("Return Items");
        $('#pageNameH6').text("Return Items");
        $.ajax({
            url: '/api/inv/getIssuedItems',
            method: 'GET'
        }).done(function (result) {
            console.log(result);
            for (let i = 0; i < result.length; i++) {
                let arr = result[i];
                let obj1 = arr[0];
                let obj2 = arr[1];
                result[i] = Object.assign({}, obj1, obj2);
            }
            $('#returnItemsTable').DataTable({
                "data": result,
                "columns": [
                    {"data": "itemName"},
                    {"data": "quantity"},
                    {"data": "itemPrice"},
                    {"data": "issuedOn"},
                    {"data": "returnDate"},
                    {"data": "status"},
                    {"data": "individualId", "visible": false},
                ],
                "rowCallback": function(row, data) {
                    $(row).on("click", function() {
                        $('tr').css({
                            "background-color": "",
                            "color": ""
                        });
                        // Set background and text color of clicked row
                        $(row).css({
                            "background-color": "red",
                            "color": "white"
                        });
                        selectedIssuedItem = data;
                    });
                }
            })
        }).fail(function (error) {
            console.log(error);
        })


        $('#output').replaceWith(fragment);
    })
}

function returnTheItem() {
    let comment = $('#comment').val();
    let quantity = $('#quantity').val();

    let obj = {
        selectedIssuedItem: selectedIssuedItem,
        comment: comment,
        quantity: quantity
    }

    $.ajax({
        url: '/api/inv/returnIssuedItem',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(obj)
    }).done(function(response) {
        response = JSON.parse(response);
        console.log(response);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>"+response.response+"</p>");
        $('#infoModal').modal('show');

        $('#infoModal #confirmOk').click(function () {
            returnItems();
        })
    }).fail(function (error) {
        console.log(error);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>"+error.response+"</p>");
        $('#infoModal').modal('show');
    })
}

function searchItem() {
    var query = $('#searchTitle').val();
    $.post('/api/inv/searchItems', {query: query}, function(results) {
        console.log(results);
        var dropdown = $("#book .searchResults");
        if (query === "") {
            dropdown.empty();
            return;
        }
        dropdown.empty();
        for (var i = 0; i < results.length; i++) {
            var data = results[i].id + "-" + results[i].itemName;
            var option = $("<option>")
                .attr("value", results[i].id)
                .text(data)
                .click(function() {
                    $('#searchTitle').val($(this).text());
                    dropdown.empty();
                })
                .hover(function() {
                    $(this).addClass('highlighted');
                }, function() {
                    $(this).removeClass('highlighted');
                });
            dropdown.append(option);
        }
    });
}

function searchReturnBook() {
    var query = $('#searchTitle').val();
    $.post('/api/lib/searchReturnBooks', {query: query}, function(answer) {
        let results = JSON.parse(answer);
        console.log(results);
        var dropdown = $("#returnBook .searchResults");
        if (query === "") {
            dropdown.empty();
            return;
        }
        dropdown.empty();
        for (var i = 0; i < results.books.length; i++) {
            var data = results.books[i].code + " - " + results.books[i].title;
            console.log(data);
            var option = $("<option>")
                .attr("value", results.books[i].code)
                .text(data)
                .click(function() {
                    $('#searchTitle').val($(this).text());
                    dropdown.empty();
                })
                .hover(function() {
                    $(this).addClass('highlighted');
                }, function() {
                    $(this).removeClass('highlighted');
                });
            dropdown.append(option);
        }
    });
}


function searchPerson() {
    var query = $('#searchPerson').val();
    var recType = $('#recipientType').val();
    console.log(recType);
    let recTypeUrl = "";
    if (recType === "Student") {
        recTypeUrl = '/api/lib/searchRecipient';
    } else if (recType === "Teacher") {
        recTypeUrl = '/api/lib/searchTeacher';
    } else if (recType === "Staff") {
        recTypeUrl = '/api/lib/searchStaff';
    }
    console.log(recTypeUrl);
    $.post(recTypeUrl, {query: query}, function(results) {
        console.log(results);
        var dropdown = $("#person .searchResults");
        if (query === "") {
            dropdown.empty();
            return;
        }
        dropdown.empty();
        for (var i = 0; i < results.length; i++) {
            var student = results[i].student;
            var teacher = results[i].teacher;
            var option = $("<option>")
                .attr("value", results[i].admNo)
                .text(student)
                .click(function() {
                    $('#searchPerson').val($(this).text());
                    dropdown.empty()
                })
                .hover(function() {
                    $(this).addClass('highlighted');
                }, function() {
                    $(this).removeClass('highlighted');
                });
            dropdown.append(option);
            var teacherOption = $("<option>")
                .attr("value", results[i].tscNo)
                .text(teacher)
                .click(function() {
                    $('#searchPerson').val($(this).text());
                    dropdown.empty()
                })
                .hover(function() {
                    $(this).addClass('highlighted-teacher');
                }, function() {
                    $(this).removeClass('highlighted-teacher');
                });
            dropdown.append(teacherOption);
        }
    });
}

function getItem(itemId) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: '/api/inv/getItem/' + itemId,
            success: function (data) {
                resolve(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}
function addItemToIssueList() {
    var itemId = $('#searchTitle').val().split("-")[0];
    console.log(itemId);
    var returnDate = $('#returnDate').val();
    var quantity = $('#quantity').val();

    getItem(itemId).then(function (item) {
        var table = $('#pendingIssueTable').DataTable();
        table.row.add([
            null,
            itemId + " - " + item.itemName,
            quantity,
            item.itemPrice,
            returnDate
        ]).draw();
        $('#itemId').val(itemId);
    }).catch(function (error) {
        console.log(error);
    });

    $('#searchTitle').val("");
}

function SaveIssue() {
    var recipient = $('#searchPerson').val();
    var recipientType = $('#recipientType').val();
    var table = $('#pendingIssueTable').DataTable();
    var rowArray = table.rows().data().toArray();
    let rowObject = {};
    let array = [];

    for (let i = 0; i < rowArray.length; i++) {
        var itemId = $('#searchTitle').val().split("-")[0];
        rowObject = {
            imageUrl: rowArray[i][0],
            itemId: rowArray[i][1].split(" -")[0],
            item: rowArray[i][1].split("- ")[1],
            quantity: rowArray[i][2],
            date: rowArray[i][4]
        };

        array.push(rowObject);
    }

    console.log(array);

    var issue = {
        recipient: recipient,
        recipientType: recipientType,
        items: array
    }

    console.log(issue);

    $.ajax({
        url: '/api/inv/issueItem',
        contentType: 'application/json',
        method: 'POST',
        data: JSON.stringify(issue)
    }).done(function(response) {
        var message = JSON.parse(response);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>"+message.response+"</p>");
        $('#infoModal').modal('show');

        $('#infoModal #confirmOk').click(function () {
            issueItems();
        })
    }).fail(function(response) {
        var message = JSON.parse(response);
        $('#infoModal .modal-body').empty();
        $('#infoModal .modal-body').append("<p>"+message.response+"</p>");
        $('#infoModal').modal('show');
    })
}

function depreciateAll() {
    $('#myModaldelete').modal('show');
    $('#myModaldelete #confirmdeletebutt').on('click', function() {
        $('#myModaldelete').modal('hide');
        $.ajax({
            url: '/api/inv/depreciateAll',
            method: 'POST',
            contentType: 'application/json'
        }).done(function (response) {
            $('#infoModal .modal-body').empty();
            $('#infoModal .modal-body').append(response.response);
            $('#infoModal').css('z-index', 10510);
            $('#infoModal').modal('show');
        }).fail(function(fail) {
            console.log(fail);
        })
    })
}

/* ----*****-----Reports -----*****----*/

function base64ToArrayBuffer(base64) {
    var binaryString = window.atob(base64);
    var binaryLen = binaryString.length;
    var bytes = new Uint8Array(binaryLen);
    for (var i = 0; i < binaryLen; i++) {
        var ascii = binaryString.charCodeAt(i);
        bytes[i] = ascii;
    }
    return bytes;
}
function print(url) {
    $("#modalprogress2").modal("show");
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define what happens when the request is successfully completed
    xhr.onload = function() {
        var sampleArr = base64ToArrayBuffer(xhr.responseText);
        var file = new Blob([sampleArr], {type: 'application/pdf'});
        var fileURL = URL.createObjectURL(file);
        window.open(fileURL);
        $("#modalprogress2").modal("hide");

        document.body.style.overflow = 'hidden';

    };

    // Send a GET request to the modal HTML file
    xhr.open('GET', url, true);
    xhr.send();
}

/* ----*****-----Reports -----*****----*/
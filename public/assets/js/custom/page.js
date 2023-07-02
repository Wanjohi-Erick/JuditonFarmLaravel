setTimeout(function () {
    $('#successMessage').fadeOut('slow');
}, 3000);

setTimeout(function () {
    $('#failureMessage').fadeOut('slow');
}, 3000);

function openModal() {
    $('#addPigModal').modal('show');
}

function openRestockModal() {
    $('#restockModal').modal('show');
}

function openEditModal(url) {


    // Retrieve the breed data using an AJAX request
    $.ajax({
        url: `${url}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (url.indexOf('breeds') !== -1) {
                $('#editName').val(response.name);
                $('#editAnimal').val(response.animal);
            } else if (url.indexOf('animal-categories') !== -1) {
                $('#editName').val(response.animal);
            } else if (url.indexOf('animal') !== -1) {
                $('#old_img').val(response.img);
                $('#editTag').val(response.tag);
                $('#edit_date_acquired').val(response.date_acquired);
                $('#edit_breed').val(response.breed);
                $('#edit_category').val(response.animal_id);
                $('#edit_weight').val(response.weight);
                $('#edit_date_last_weighed').val(response.date_last_weighed);
                $('#edit_gender').val(response.gender);
                $('#edit_description').val(response.description);
            }
            else if (url.indexOf('animal-treatment') !== -1) {
                $('#editTag').val(response.tag);
                $('#edit_type').val(response.type);
                $('#edit_product').val(response.product);
                $('#edit_application_method').val(response.application_method);
                $('#edit_days_until_withdrawal').val(response.days_until_withdarawal);
                $('#edit_technician').val(response.date_last_weighed);
                $('#edit_dosage').val(response.dosage);
                $('#edit_treatment_date').val(response.treatment_date);
                $('#edit_body_part').val(response.body_part);
                $('#edit_booster_date').val(response.booster_date);
                $('#edit_total_cost').val(response.total_cost);
                $('#edit_description').val(response.description);
            }


            // Show the modal
            $('#editPigModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });

    $('#editPigModal').modal('show');
}

function openDeleteModal(url) {

    $('#modal-delete').modal('show');

    $('#confirmDelete').click(function () {
        window.location.href = url;
    })
}

function openAddGroupModal() {
    $('#addPigModal').modal('hide');
    $('#addGroupModal').modal('show');
}

function deleteItem(url) {
    $('#modal-delete').modal('show');
    $('#confirmDelete').on('click', function() {
        $('#modal-delete').modal('hide');
        $.ajax({
            url: url,
            method: 'GET',
            contentType: 'application/json'
        }).done(function (response) {
            $('#successMessage').text(response.message).show();
            location.reload();
        }).fail(function(fail) {
            $('#failureMessage').text(fail).show();
        })
    })
}

$(document).ready(function() {
    // Bind submit event to the form
    $('#addItemForm').submit(function(event) {
        // Prevent the form from submitting normally
        event.preventDefault();

        $('#addPigModal').modal('hide');
        // Get the form data
        var formData = $(this).serialize();

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '/save-item',
            data: formData,
            success: function(response) {
                $('#successMessage').text(response.message).show();
                location.reload();
            },
            error: function(error) {
                console.log(error);
                $('#failureMessage').text(error.responseJSON.error).show();
                setTimeout(function () {
                    $('#failureMessage').hide();
                }, 2000);
            }
        });
    });
    $('#addGroupForm').submit(function (event) {
        event.preventDefault();
        $('#addGroupModal').modal('hide');
        // Get the form data
        var formData = $(this).serialize();

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '/save-item-group',
            data: formData,
            success: function(response) {
                $('#successMessage').text(response.message).show();
                openModal();
            },
            error: function(error) {
                console.log(error);
                $('#failureMessage').text(error.responseJSON.message).show();
                setTimeout(function () {
                    $('#failureMessage').hide();
                }, 2000);
            }
        });
    })

    $('#restockItemForm').submit(function (event) {
        event.preventDefault();
        $('#restockModal').modal('hide');
        // Get the form data
        var formData = $(this).serialize();

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '/restock-item',
            data: formData,
            success: function(response) {
                $('#successMessage').text(response.message).show();
                location.reload();
            },
            error: function(error) {
                console.log(error);
                $('#failureMessage').text(response.error).show();
                setTimeout(function () {
                    $('#failureMessage').hide();
                }, 2000);
            }
        });
    })
});

function getGroups() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/getItemGroups',
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}

function getVendors() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/getVendors',
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
            url: '/getAllItems',
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}

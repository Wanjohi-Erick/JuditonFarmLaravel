setTimeout(function () {
    $('#successMessage').fadeOut('slow');
}, 3000);

setTimeout(function () {
    $('#failureMessage').fadeOut('slow');
}, 3000);

function openModal() {
    $('#addPigModal').modal('show');
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

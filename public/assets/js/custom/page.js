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

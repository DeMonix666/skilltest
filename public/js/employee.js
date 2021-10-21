"use strict";

$(function () {
    $('#employee-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'employee/list',
        columns: [
            {
                data: 'firstname'
            },
            {
                data: 'lastname'
            },
            {
                data: 'email'
            },
            {
                data: 'phone'
            },
            {
                data: 'company_name'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    function refresh() {
        var table = $('#employee-table').DataTable();
        table.ajax.reload(null, false);
    }

    function cleaner() {
        $('.id').val('');
        $('.firstname').val('');
        $('.lastname').val('');
        $('.email').val('');
        $('.phone').val('');
        $('.company_id').val('');
    }

    function token() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    //create
    $(document).on('click', '.create', function (e) {
        e.preventDefault();

        cleaner();
        $('#modalAdd').modal('show');
        $('.modal-title').text('Create Employee');
    });

    //edit
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('employee_id');

        token();

        $.ajax({
            url: 'employee/' + id + '/edit',
            method: 'get',
            success: function (result) {

                if (result.success) {
                    let json = jQuery.parseJSON(result.data);

                    $('.id').val(json.id);
                    $('.firstname').val(json.firstname);
                    $('.lastname').val(json.lastname);
                    $('.email').val(json.email);
                    $('.phone').val(json.phone);
                    $('.company_id').val(json.company_id);

                    $('#modalEdit').modal('show');
                    $('.modal-title').text('Update Employee');
                }
            }
        });
    });

    //store
    $(document).on('submit', '#modalAdd', function (e) {
        e.preventDefault();

        var formData = $("form#store").serializeArray();
        $('#store .form-error').html('');

        token();

        var data = {
            firstname: formData[0].value,
            lastname: formData[1].value,
            email: formData[2].value,
            phone: formData[3].value,
            company_id: (formData[4] != undefined)? formData[4].value : null,
        };

        $.ajax({
            url: "employee",
            method: 'post',
            data: data,
            success: function (result) {
                if (result.success) {
                    refresh();
                    $('#modalAdd').modal('hide');
                    swal(
                        'Good job!',
                        'Successfull Saved!',
                        'success'
                    );
                }
            },
            error: function(xhr, status, error){
                if (xhr.responseJSON.errors != undefined){
                    for (const [key, value] of Object.entries(xhr.responseJSON.errors)) {
                        $('#store .' + key + 'Error').html(value[0]);
                    }
                }
            }

        });
    });

    //update
    $(document).on('submit', '#modalEdit', function (e) {
        e.preventDefault();

        var formData = $("form#update").serializeArray();
        $('#update .form-error').html('');

        token();

        var id = formData[0].value
        var data = {
            firstname: formData[1].value,
            lastname: formData[2].value,
            email: formData[3].value,
            phone: formData[4].value,
            company_id: formData[5].value,
        };

        $.ajax({
            url: "employee/" + id,
            method: 'PUT',
            data: data,
            success: function (result) {
                if (result.success) {
                    refresh();
                    cleaner();
                    $('#modalEdit').modal('hide');
                    swal(
                        'Updated!',
                        'Successfull Update!',
                        'success'
                    );
                }
            },
            error: function(xhr, status, error){
                if (xhr.responseJSON.errors != undefined){
                    for (const [key, value] of Object.entries(xhr.responseJSON.errors)) {
                        $('#update .' + key + 'Error').html(value[0]);
                    }
                }
            }
        });
    });

    //delete data
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('employee_id');

        swal({
            title: 'Are you sure?',
            text: "you want to remove this record?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                token();

                $.ajax({
                    url: 'employee/' + id,
                    method: 'DELETE',
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();
                            swal(
                                'Deleted!',
                                'Successfull Deleted!',
                                'success'
                            );
                        }
                    }
                });
            }
        });

    });
});
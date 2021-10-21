"use strict";
// import Swal from 'sweetalert2';

$(function () {
    $('#company-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'company/list',
        columns: [
            {
                data: 'logo', 
                name: 'logo',
                render:function (data, type, full, meta) {
                    return (data) ? '<img src="' + data.replace('public/', 'storage/') + '" class="img-thumbnail" />' : null;
                }
            },
            {
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    function refresh() {
        var table = $('#company-table').DataTable();
        table.ajax.reload(null, false);
    }

    function cleaner() {
        $('.id').val('');
        $('.name').val('');
        $('.email').val('');
        $('.logo').val('');
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
        $('.modal-title').text('Create Company');
    });

    //edit
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('company_id');

        token();

        $.ajax({
            url: 'company/' + id + '/edit',
            method: 'get',
            success: function (result) {

                if (result.success) {
                    let json = jQuery.parseJSON(result.data);

                    $('.id').val(json.id);
                    $('.name').val(json.name);
                    $('.email').val(json.email);
                    $('#company-logo-edit').val('');

                    $('#modalEdit').modal('show');
                    $('.modal-title').text('Update Company');
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

        var data = new FormData();
        data.append('name', formData[0].value);
        data.append('email', formData[1].value);

        if ($('#company-logo-add').val().length > 0){
            data.append('logo', $('#company-logo-add').val());
            data.append('logo', $('#company-logo-add')[0].files[0]);
        }

        $.ajax({
            url: "company",
            method: 'post',
            data: data,
            contentType: false,
            processData: false,
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

        var data = new FormData();
        var id = formData[0].value;
        data.append('id', id);
        data.append('name', formData[1].value);
        data.append('email', formData[2].value);
        
        if ($('#company-logo-edit').val().length > 0){
            data.append('logo', $('#company-logo-edit').val());
            data.append('logo', $('#company-logo-edit')[0].files[0]);
        }

        $.ajax({
            url: "company/" + id,
            method: 'PUT',
            type: 'PUT',
            data: data,
            contentType: false,
            processData: false,
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
        var id = $(this).attr('company_id');

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
                    url: 'company/' + id,
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
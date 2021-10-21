@extends('layouts.app')

@section('title')
    {{ __('Companies') }}
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading mb-2">
            <h3 class="panel-title float-left">
                {{ __('Companies') }}
            </h3>
            <div class="float-right">
                <button class="btn btn-success create"><i class="glyphicon glyphicon-plus"></i> {{ __('Create') }}</button>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="table-responsive">
            <table id="company-table" class="table">
                <thead>
                    <td width="10%">{{ __('Logo') }}</td>
                    <td>{{ __('Name') }}</td>
                    <td>{{ __('Email') }}</td>
                    <td>{{ __('Action') }}</td>
                </thead>
            </table>  
        </div>
         
    </div>
    
    <div id="modalAdd" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form id="store">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control name" name="name" placeholder="" >
                            <span class="text-danger form-error nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control email" name="email" placeholder="" >
                            <span class="text-danger form-error emailError"></span>
                        </div>
                        <div class="form-group">
                            <label for="logo">{{ __('Select file') }}</label>
                            <input type="file" id="company-logo-add" class="form-control logo" name="logo">
                            <span class="text-danger form-error logoError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="modal fade" role="dialog">
        <div class="modal-dialog d-flex flex-column justify-content-center" role="document">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="update">
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control name" name="name" placeholder="" >
                            <span class="text-danger form-error nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control email" name="email" placeholder="" >
                            <span class="text-danger form-error emailError"></span>
                        </div>
                        <div class="form-group">
                            <label for="logo">{{ __('Select file') }}</label>
                            <input type="file" id="company-logo-edit" class="form-control logo" name="logo">
                            <span class="text-danger form-error logoError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
@endsection

@push('scripts')
    <script src="{{ asset('js/company.js') }}"></script>
@endpush


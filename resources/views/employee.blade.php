@extends('layouts.app')

@section('title')
    {{ __('Employee') }}
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading mb-2">
            <h3 class="panel-title float-left">
                {{ __('Employee') }}
            </h3>
            <button class="btn btn-success float-right create"><i class="glyphicon glyphicon-plus"></i> {{ __('Create') }}</button>
            <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
            <table id="employee-table" class="table">
                <thead>
                    <td>{{ __('First Name') }}</td>
                    <td>{{ __('Last Name') }}</td>
                    <td>{{ __('Email') }}</td>
                    <td>{{ __('Phone') }}</td>                    
                    <td>{{ __('Company') }}</td>
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
                            <label for="firstname">{{ __('First Name') }}</label>
                            <input type="text" class="form-control firstname" name="firstname" placeholder="Enter firstname">
                            <span class="text-danger form-error firstnameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="lastname">{{ __('Last Name') }}</label>
                            <input type="text" class="form-control lastname" name="lastname" placeholder="Enter last name">
                            <span class="text-danger form-error lastnameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control email" name="email" placeholder="Enter email">
                            <span class="text-danger form-error emailError"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" class="form-control phone" name="phone" placeholder="Enter phone">
                            <span class="text-danger form-error phoneError"></span>
                        </div>
                        <div class="form-group">
                            <label for="company_id">{{ __('Company') }}</label>
                            <select class="form-control company_id" name="company_id">
                                <!-- <option>{{ __('Select Company') }}</option> -->
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" }}> 
                                        {{ $company->name }} 
                                    </option>
                                @endforeach    
                            </select>
                            <span class="text-danger form-error company_idError"></span>
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
        <div class="modal-dialog">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form id="update">
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label for="firstname">{{ __('First Name') }}</label>
                            <input type="text" class="form-control firstname" name="firstname" placeholder="Enter firstname">
                            <span class="text-danger form-error firstnameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="lastname">{{ __('Last Name') }}</label>
                            <input type="text" class="form-control lastname" name="lastname" placeholder="Enter last name">
                            <span class="text-danger form-error lastnameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control email" name="email" placeholder="Enter email">
                            <span class="text-danger form-error emailError"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" class="form-control phone" name="phone" placeholder="Enter phone">
                            <span class="text-danger form-error phoneError"></span>
                        </div>
                        <div class="form-group">
                            <label for="company_id">{{ __('Company') }}</label>
                            <select class="form-control company_id" name="company_id">
                                <!-- <option>{{ __('Select Company') }}</option> -->
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" }}> 
                                        {{ $company->name }} 
                                    </option>
                                @endforeach    
                            </select>
                            <span class="text-danger form-error company_idError"></span>
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
    <script src="{{ asset('js/employee.js') }}"></script>
@endpush


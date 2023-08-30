@extends('layouts.admin')
@section('content')

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@can('scholarship_provider_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.scholarship-providers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.scholarshipProvider.title_singular') }}
            </a>

            <a class="btn btn-success" href="{{route('sfccreate')}}">
                ADD SFC NGO
            </a>
            <a class="btn btn-success"  id="addUserBtn">
                ADD Company Users
            </a>
            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="POST" action="{{route('addcompanyusers')}}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number:</label>
                            <input type="text" name="mobile" id="mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company_id">Company Name:</label>
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">Select Company</option>
                                @foreach($scholarshipProviders as $company)
                                    <option value="{{ $company->id }}">{{ $company->organization_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveUserBtn">Save User</button>
                </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.scholarshipProvider.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ScholarshipProvider">
                <thead>
                    <tr>
                        <th width="10">
                            <input type="checkbox" name="">
                        </th>
                        <th>
                            {{ trans('cruds.scholarshipProvider.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.scholarshipProvider.fields.organization_name') }}
                        </th>
                        
                        
                        
                        <th>
                            Action&nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scholarshipProviders as $key => $scholarshipProvider)
                        <tr data-entry-id="{{ $scholarshipProvider->id }}">
                            <td>
                                <input type="checkbox" name="prodid[]" value="id" class="prodid">

                            </td>
                            <td>
                                {{ $scholarshipProvider->id ?? '' }}
                            </td>
                            <td>
                                {{ $scholarshipProvider->organization_name ?? '' }}
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        // Debug: Check if the click event is triggered
        console.log('Document is ready. Click event should work.');

        // Show the modal when the "Add Company Users" button is clicked
        $('#addUserBtn').on('click', function () {
            // Debug: Check if this code block is executed
            console.log('Add Company Users button is clicked. Modal should show.');
            $('#addUserModal').modal('show');
        });

        // ... Rest of your script ...

    });
</script>
@endsection






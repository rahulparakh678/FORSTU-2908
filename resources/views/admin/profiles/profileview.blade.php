@extends('layouts.admin')
@section('content')
@can('profile_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.profiles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.profile.title_singular') }}
            </a>
            <a class="btn btn-success" href="{{route('studstatus')}}">
                 Add SFC Scholarship Status 
            </a>
{{--
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
  Add SFC Scholarship Status
</button>
--}}

{{--
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('storestatus')}}" enctype="multipart/form-data">
            @csrf
        
        <div class="form-group">
            <label>Full Name</label>
            <label class="required" for="student_name">{{ trans('cruds.scholarshipAchiever.fields.student_name') }}</label>
                <select class="form-control select2" name="user_id" id="student_name">
                    @foreach(App\StudentProfile::all() as $student_name)
                        <option value="{{$student_name->user_id}}">{{$student_name->fullname}}</option>
                    @endforeach
                    
                </select>
        </div>
        <div class="form-group">
                <label class="required" for="scheme_name">Scholarship Name</label>
                <input type="text" name="scheme_name" class="form-control">

        </div>
        <div class="form-group">
                <label>Attachments</label> <br>
                <input type="file" name="applicationpdf">
        </div>
        <div class="form-group">
                <label class="required" for="student_name">Status</label>
                <select class="form-control" name="status">
                    <option value="Application Submitted">Application Submitted</option>

                    <option value="Shortlised">Shortlised</option>
                    <option value="Awarded">Awarded</option>
                    <option value="Fund Disbursed">Fund Disbursed</option>
                    <option value="Better Luck Next Time">Better Luck Next Time</option>
                </select>
        </div>
         <div class="form-group">
                <label>Application Date</label>
                <input type="datetime-local" name="created_at" class="form-control">
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
--}}

            <a class="btn btn-success" href="{{route('smsstatus')}}">
                Add SMS Scholarship Status
            </a>
            <a class="btn btn-success" href="{{route('editstudstatus')}}">
                Edit Scholarship Status
            </a>
            <a class="btn btn-success" href="{{route('allstatus')}}">
                View All Status
            </a>
             <a class="btn btn-success" href="{{route('filterview')}}">
                Filtered View
            </a>
            <a class="btn btn-success" href="{{route('profileremarks')}}">
                Profile Wise Remarks
            </a>
            <form action="{{route('uploadUsers')}} " method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
    
    
                        <input type="file" name="excel_file" required>
                        <button class="btn btn-success" type="submit" value="Upload">Upload </button>
                
                        </form>     
            
            <span data-href="{{route('export')}}" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Export Student Profiles</span>
            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.profile.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
        @endif
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover datatable datatable-Profile">

              
                <thead>
                    <tr>
                        <th width="10"></th>
            <th>
                            Profile {{ trans('cruds.profile.fields.id') }}
            </th>
            <th>
                            {{ trans('cruds.profile.fields.full_name') }}
            </th>
            <th>Mobile</th>
            <th>Email Address</th>
            <th>Gender</th>
            <th>Personal Details Completed</th>
            <th>Family Details Completed</th>
            <th>Communication Details Completed</th>
            <th>Bank Details Completed</th>
            <th>Current Course Completed</th>
            <th>Class 10 Completed</th>
            <th>Class 12 Completed</th>
            <th>Diploma Details Completed</th>
            <th>Graduation Details Completed</th>
            <th>Created At</th>
            <th>Ref Code</th>          
                        
                        
                    </tr>
                    
                </thead>
                <tbody>
                    
                @foreach($profiles as $profile)
                    <tr>
                        <td>
                                @can('profile_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.profiles.show', $profile->id) }}" target="_blank">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                        </td>
                        <td>
                                {{ $profile->id }}
                        </td>
                        <td>{{ $profile->fullname ?? '' }}</td>
                        <td>{{$profile->mobile}}</td>
                        <td>{{$profile->email}}</td>
                        <td>{{$profile->gender}}</td>
                        <td>{{$profile->personaldetails_completed}}</td>
                        <td>{{$profile->familydetails_completed}}</td>
                        <td>{{$profile->communicationdetails_completed}}</td>
                        <td>{{$profile->bankdetails_completed}}</td>
                        <td>{{$profile->currentcoursedetails_completed}}</td>
                        <td>{{$profile->class10_details_completed}}</td>
                        <td>{{$profile->class12_details_completed}}</td>
                        <td>{{$profile->diploma_details_completed}}</td>
                        <td>{{$profile->graduation_details_completed}}</td>
                        <td>{{$profile->created_at}}</td>
                        <td>{{$profile->ref_code}}</td>
                    </tr>
                @endforeach
                   

                
                
                </tbody>
            </table>
  
            <?php /*
            {{ -- $profile->appends(Illuminate\Support\Facades\Request::except('page'))--}} */?>
        </div>
    </div>
 
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {

         let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
$.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'DESC' ]],
    pageLength: 10,
  });
  

 table = $('.datatable-Profile:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
  
})

</script>
<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
@endsection

@extends('layouts.sfcngo')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.profile.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="row" style="margin-bottom: 20px;">
          <a href="{{route('sfcfilteredview')}}" class="btn btn-xs btn-danger" target="_blank">Apply Filters</a> &nbsp
          <a href="{{ request()->fullUrl() }}" class="btn btn-xs btn-info">Remove Filter</a>
        </div>
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover datatable datatable-Profile">

              
                <thead>
                    <tr>

                  
                        <th width="10">

                        </th>
                        <th width="10">
                            Profile ID
                        </th>
                        <th>Student Name</th>
                        
                        
                        <th>Action</th>
                        
                        
                    </tr>
                    <tr>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        
                       
                        
                        <td></td>
                    </tr>
                    
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                      <td></td>
                      <td>
                       
                       
                         {{$profile->id}}
                       </td>
                      
                      <td>{{ $profile->name}}</td>
                      
                      
                      <td>
                        
                      <a href="{{ route('profileshow1', $profile->id) }}"  target="_blank" class="btn btn-primary">View Profile </a>
                     
                      </td>
                      </form>
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
@endsection


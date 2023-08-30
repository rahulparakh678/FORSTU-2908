@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Scholarship Activity
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table  table-bordered table-striped table-hover datatable datatable-Caste">
                <thead>
                    <tr>
                        <th width="10">
                            User id
                        </th>
                        <th>
                            User Name
                        </th>
                        <th>Scholarship Name</th>
                        <th>
                            Time Stamp
                        </th>
                        <th>
                            Ref Code
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($activities as $key => $activities)
                        <tr data-entry-id="{{ $activities->id }}">
                            <td>
                                {{ $activities->user_id ?? '' }}
                            </td>
                            <td>
                                {{ $activities->user_name ?? '' }}
                            </td>
                            <td>
                                {{ $activities->scholarship_name ?? '' }}
                            </td>
                            <td>
                                {{ $activities->clicked_at ?? '' }}
                            </td>
                            <td>
                               {{ $activities->ref_code ?? '' }}
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
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('caste_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.castes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Caste:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})
 $(document).ready(function () {
        // Event listener for remove button click
        $('.remove-btn').on('click', function () {
            var row = $(this).closest('tr');
            var userId = row.data('entry-id');

            // Send an AJAX request
            $.ajax({
                url: '/users/hide/' + userId, // Replace with your route URL
                type: 'PUT',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        row.hide(); // Hide the row on success
                    } else {
                        alert('Error hiding the row. Please try again.');
                    }
                },
                error: function () {
                    alert('Error hiding the row. Please try again.');
                }
            });
        });
    });

</script>
@endsection
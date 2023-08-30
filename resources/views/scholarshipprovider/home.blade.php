@extends('layouts.scholarshipprovider')
<!-- Add this script tag in your HTML file where you want to use Chart.js -->



@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! {{Auth::user()->name}}
                    {{$listschemes}}
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @if (!empty($listschemes))
        <div class="form-group">
            <label for="schemeDropdown">Select a Scheme:</label>
            <select id="schemeDropdown" class="form-control">
                <option value="">Please Select</option>
                @foreach ($listschemes as $scheme)
                    <option value="{{ $scheme->id }}">{{ $scheme->scheme_name }}</option>
                @endforeach
            </select>
        </div>
    @else
        <div class="alert alert-info">
            You don't have any scholarships listed yet.
        </div>
    @endif
</div>

<div class="container-fluid">
    <h2>Applications List</h2>
    <div id="applicationsList">
        <!-- The application list will be populated here using AJAX -->
    </div>
</div>

<style>
    /* Customize the padding and font size for the dropdown */
    @media (max-width: 576px) {
        #schemeDropdown {
            padding: 0.375rem 0.75rem;
            font-size: 14px;
        }
    }

    /* Customize the alert font size for smaller screens */
    @media (max-width: 576px) {
        .alert-info {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('scripts')
@parent
<script>
    // JavaScript code using jQuery (Make sure you have jQuery loaded)
    $(document).ready(function() {
        // Function to fetch the list of applications based on the selected scheme_id
        function fetchApplicationData(schemeId) {
            // Your AJAX call to fetch the list of applications based on schemeId
            $.ajax({
                method: 'GET',
                url: `/api/application-list/${schemeId}`, // Define your API endpoint to fetch application list
                success: function(data) {
                    displayApplicationsList(data);
                },
                error: function(xhr, textStatus, error) {
                    console.error(error);
                }
            });
        }

        // Function to display the list of applications
        function displayApplicationsList(applications) {
            // Clear previous application list
            $('#applicationsList').empty();

            // Create a table to display the applications
            var table = $('<table>').addClass('table table-bordered');
            var tableHead = $('<thead>').append(
                $('<tr>').append(
                    $('<th>').text('User ID'),
                    $('<th>').text('Scholarship ID'),
                    $('<th>').text('Application Date')
                )
            );
            var tableBody = $('<tbody>');

            // Add each application to the table
            applications.forEach(function(application) {
                var row = $('<tr>').append(
                    $('<td>').text(application.user_id),
                    $('<td>').text(application.scholarship_id),
                    $('<td>').text(application.created_at)
                );
                tableBody.append(row);
            });

            // Append table head and body to the table
            table.append(tableHead, tableBody);

            // Append the table to the applicationsList div
            $('#applicationsList').append(table);
        }

        // Event listener for the schemeDropdown change
        $('#schemeDropdown').change(function() {
            var schemeId = $(this).val();
            fetchApplicationData(schemeId);
        });
    });
</script>

@endsection

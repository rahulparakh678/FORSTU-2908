@extends('layouts.scholarshipprovider')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.setupscholarship.title_singular') }}
    </div>

    <div class="card-body">
    	<h2>Scholarship Application Form </h2>
    	<hr>
    	<h2>Section 1</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
           
            <div class="form-group">
                <label for="company_id">Company Name:</label>
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->organization_name }}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label for="financial_year">Financial Year:</label>
                <select name="financial_year" id="financial_year" class="form-control" required>
                    <option value="">Select Financial Year</option>
                    <option value="">F.Y 2023-24</option>
                    <!-- Add options for financial years -->
                </select>
            </div>
             <div class="form-group">
                <label for="scheme_name">Scholarship Scheme Name:</label>
                <input type="text" name="scheme_name" id="scheme_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Long Description about Scholarship Scheme:</label>
                <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
            </div>
             <div class="form-group">
                <label for="support_type">Select Support Type:</label>
                <select name="support_type" id="support_type" class="form-control" required>
                	<option value="#">Please Select</option>
                    <option value="scholarship">Only Scholarship</option>
                    <option value="scholarship_mentorship">Scholarship + Mentorship</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label for="how_to_apply">How to Apply (Long Question):</label>
                <textarea name="how_to_apply" id="how_to_apply" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="contact_details">Contact Details (Long Question):</label>
                <textarea name="contact_details" id="contact_details" class="form-control" rows="5" required></textarea>
            </div>
        </form>
            <hr>
            <h2>Section 2</h2>
        	<div class="form-group">
    			<label for="courses">Select Courses:</label>
    			<select name="courses[]" id="courses" class="form-control select2" multiple required>
        			@foreach ($studentCourses as $course)
            			<option value="{{ $course->id }}">{{ $course->course_name }}</option>
        			@endforeach
    			</select>
			</div>
			<div class="form-group">
    			<label for="current_year">Select Current Year of Education Eligible:</label>
    			<select name="current_year[]" id="current_year" class="form-control select2" multiple required>
        <!-- Add options for current year dynamically using a loop or PHP code -->
        			<option value="1">First Year</option>
        			<option value="2">Second Year</option>
        			<option value="3">Third Year</option>
        <!-- Add more options as needed -->
    			</select>
			</div>
			<div class="form-group">
    			<label>Gender Allowed:</label><br>
    			<select name="gender[]" id="gender" class="form-control select2" multiple>
        		<option value="male">Male</option>
        		<option value="female">Female</option>
        		<option value="transgender">Transgender</option>
    			</select>
			</div>
			<div class="form-group">
    			<label for="max_annual_income">Max Annual Income Allowed:</label>
    			<input type="text" name="max_annual_income" id="max_annual_income" class="form-control">	
			</div>
            <div class="form-group">
                <label>Any restriction on Class 10 Percentage?</label><br>
                <input type="radio" name="class_10_restriction" value="yes" id="class_10_yes"> Yes
                <input type="radio" name="class_10_restriction" value="no" id="class_10_no"> No
            </div>
            <div class="form-group" id="class_10_restriction_fields" style="display: none;">
                <label for="class_10_percentage">Class 10 Percentage Restriction:</label>
                <input type="number" name="class_10_percentage" id="class_10_percentage" class="form-control" step="0.01" min="0" max="100">
            </div>
            <div class="form-group">
                <label>Any restriction on Class 12 Percentage?</label><br>
                <input type="radio" name="class_12_restriction" value="yes" id="class_12_yes"> Yes
                <input type="radio" name="class_12_restriction" value="no" id="class_12_no"> No
            </div>

            <div class="form-group" id="class_12_restriction_fields" style="display: none;">
                <label for="class_12_percentage">Class 12 Percentage Restriction:</label>
                <input type="number" name="class_12_percentage" id="class_12_percentage" class="form-control" step="0.01" min="0" max="100">
            </div>
            <div class="form-group">
                <label>Any restriction on Diploma Percentage?</label><br>
                <input type="radio" name="diploma_restriction" value="yes" id="diploma_yes"> Yes
                <input type="radio" name="diploma_restriction" value="no" id="diploma_no"> No
            </div>
            <div class="form-group" id="diploma_restriction_fields" style="display: none;">
                <label for="diploma_percentage">Diploma Percentage Restriction:</label>
                <input type="number" name="diploma_percentage" id="diploma_percentage" class="form-control" step="0.01" min="0" max="100">
            </div>
            <div class="form-group">
                <label>Any restriction on Graduation Percentage?</label><br>
                <input type="radio" name="graduation_restriction" value="yes" id="graduation_yes"> Yes
                <input type="radio" name="graduation_restriction" value="no" id="graduation_no"> No
            </div>
            <div class="form-group" id="graduation_restriction_fields" style="display: none;">
                <label for="graduation_percentage">Graduation Percentage Restriction:</label>
                <input type="number" name="graduation_percentage" id="graduation_percentage" class="form-control" step="0.01" min="0" max="100">
            </div>
            <div class="form-group">
                <label>Any restriction on Previous Percentage?</label><br>
                <input type="radio" name="previous_restriction" value="yes" id="previous_yes"> Yes
                <input type="radio" name="previous_restriction" value="no" id="previous_no"> No
            </div>
            <div class="form-group" id="previous_restriction_fields" style="display: none;">
                <label for="previous_percentage">Previous Percentage Restriction:</label>
                <input type="number" name="previous_percentage" id="previous_percentage" class="form-control" step="0.01" min="0" max="100">
            </div>
            <div class="form-group">
                <label>State-wise Eligibility:</label><br>
                <input type="radio" name="state_eligibility_option" value="yes" id="state_eligibility_yes"> Yes
                <input type="radio" name="state_eligibility_option" value="no" id="state_eligibility_no"> No
            </div>

            <div class="form-group" id="state_eligibility_fields" style="display: none;">
                <label for="state_eligibility">Select State(s):</label>
                <select name="state_eligibility[]" id="state_eligibility" class="form-control select2" multiple>
                    @foreach (App\StudentProfile::STATE_SELECT as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Is there any crisis-wise preference?</label><br>
                    <input type="radio" name="has_crisis_preference" value="yes" id="has_crisis_preference_yes"> Yes<br>
                    <input type="radio" name="has_crisis_preference" value="no" id="has_crisis_preference_no" checked> No<br>
            </div>
            <div class="form-group" id="crisis_preference_section" style="display: none;">
                <label for="crisis_preference">Crisis-wise Preference:</label>
                    <select name="crisis_preference[]" id="crisis_preference" class="form-control select2" multiple>
                        <option value="single_parent">Single Parent</option>
                        <option value="orphan">Orphan</option>
                        <option value="differently_abled">Differently Abled</option>
                    </select>
            </div>
            <hr>
            <h2>Section 3</h2>
            <div class="form-group">
                <label for="scholarship_type">Scholarship Type:</label>
                <select name="scholarship_type" id="scholarship_type" class="form-control">
                    <option value="one_time">One Time</option>
                    <option value="renewal">Renewal</option>
                </select>
            </div>
            
            <!-- Add similar lines for other districts -->
        </div>
    </div>
</div>

    </div>
    

</div>
	
@endsection
@section('scripts')
<!-- Script for Select2 on "Select Courses" -->
<script>
    $(document).ready(function() {
        // Initialize Select2 for "Select Courses"
        $('#courses').select2({
            placeholder: 'Select courses',
            allowClear: true,
            minimumInputLength: 0,
        });
    });
</script>

<!-- Script for Select2 on "Select Current Year" -->
<script>
    $(document).ready(function() {
        // Initialize Select2 for "Select Current Year"
        $('#current_year').select2({
            placeholder: 'Select Current Year',
            allowClear: true,
            minimumInputLength: 1,
        });
    });
</script>

<!-- Script for Select2 on "Gender Allowed" -->
<script>
    $(document).ready(function() {
        // Initialize Select2 for "Gender Allowed"
        $('#gender').select2({
            placeholder: 'Select gender(s)',
            allowClear: true,
            minimumInputLength: 0,
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('input[name="class_10_restriction"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#class_10_restriction_fields').show();
            } else {
                $('#class_10_restriction_fields').hide();
            }
        });

        $('input[name="class_12_restriction"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#class_12_restriction_fields').show();
            } else {
                $('#class_12_restriction_fields').hide();
            }
        });

        // Repeat similar code for Diploma, Graduation, and Previous Percentage
    });
</script>
<script>
    $(document).ready(function() {
        $('input[name="diploma_restriction"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#diploma_restriction_fields').show();
            } else {
                $('#diploma_restriction_fields').hide();
            }
        });

        $('input[name="graduation_restriction"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#graduation_restriction_fields').show();
            } else {
                $('#graduation_restriction_fields').hide();
            }
        });

        $('input[name="previous_restriction"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#previous_restriction_fields').show();
            } else {
                $('#previous_restriction_fields').hide();
            }
        });
    });
</script>
<script type="text/javascript">
     $(document).ready(function() {
        $('input[name="state_eligibility_option"]').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'yes') {
                $('#state_eligibility_fields').show();
                $('#state_eligibility').val(null).trigger('change'); // Clear selected options

            } else {
                $('#state_eligibility_fields').show(); // Hide the field
                $('#state_eligibility').val(Object.keys(@json(App\StudentProfile::STATE_SELECT))).trigger('change'); // Select all options
            }
        });

        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select states',
            allowClear: true,
        });
    });
</script>
<script>
     $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select options',
            allowClear: true
        });

        // Toggle crisis preference section based on user selection
        $('input[name="has_crisis_preference"]').on('change', function() {
            var isChecked = $(this).val() === 'yes';
            $('#crisis_preference_section').toggle(isChecked);
            if (!isChecked) {
                $('#crisis_preference').val(null).trigger('change'); // Clear the selected options
            }
        });
    });
</script>
@endsection
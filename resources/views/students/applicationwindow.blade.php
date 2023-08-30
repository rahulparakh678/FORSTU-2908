@extends('layouts.student')

@section('content')

@if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('message') !!}</li>
        </ul>
    </div>
@endif

<div id="accordion">
<form method="POST" action="{{route('storedetails1')}} " enctype="multipart/form-data">
            @csrf

             
            
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            <input type="hidden" name="ref_code" value="{{auth()->user()->ref_code}}">
            
            <input type="hidden" name="personaldetails_completed" value="Yes">
    <div class="card" id="personal_details">

            
    
        <div class="card-header collapsed card-link " data-toggle="collapse" data-target="#collapseOne" >
                Personal Details 
                @if(isset($profile->personaldetails_completed))
                <i class="fa fa-check-circle " style="font-size:24px;color:green; "></i>
                @else
            <span class="badge badge-danger">Incomplete Details</span>
            
                @endif
                <i class="fa fa-plus " style="float:right;"></i>
        </div>

        <div id="collapseOne" class="collapse" data-parent="#accordion">
            <div class="card-body">
        
            	<div class="form-group">
					 <label class="required" for="fullname">{{ trans('cruds.studentDetail.fields.fullname') }}</label>
					 <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', auth::user()->name) }} " required>
					 @if($errors->has('fullname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fullname') }}
                    </div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.fullname_helper') }}</span>
				</div>
				<div class="form-group">
                	<label class="required" for="email">{{ trans('cruds.studentDetail.fields.email') }}</label>
                	<input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email',auth::user()->email) }}" required>
                	@if($errors->has('email'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('email') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.email_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="mobile">{{ trans('cruds.studentDetail.fields.mobile') }}</label>
                	<input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', auth::user()->mobile) }}" required>
               		 @if($errors->has('mobile'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('mobile') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.mobile_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required">{{ trans('cruds.studentDetail.fields.gender') }}</label>
                	@foreach(App\StudentProfile::GENDER_RADIO as $key => $label)
                    	<div class="form-check {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                        	<input class="" type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', auth::user()->gender) === (string) $key ? 'checked' : '' }} required>
                        	<label class="radio-inline" for="gender_{{ $key }}">{{ $label }}</label>
                    	</div>
                	@endforeach
                	@if($errors->has('gender'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('gender') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.gender_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="dob">{{ trans('cruds.studentDetail.fields.dob') }}</label>
                	<input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob', $profile->dob ?? '') }}" required>
                		@if($errors->has('dob'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('dob') }}
                    	</div>
                		@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.dob_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required">{{ trans('cruds.studentDetail.fields.religion') }}</label>
                	<select class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" name="religion" id="religion" required>
                    	<option value disabled {{ old('religion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    	@foreach(App\StudentProfile::RELIGION_SELECT as $key => $label)
                        	<option value="{{ $key }}" {{ old('religion',$profile->religion ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    	@endforeach
                	</select>
               		 	@if($errors->has('religion'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('religion') }}
                    	</div>
                		@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.religion_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label for="caste_id">{{ trans('cruds.studentDetail.fields.caste') }}</label>
                	<select class="form-control select2 {{ $errors->has('caste') ? 'is-invalid' : '' }}" name="caste_id" id="caste_id" required>
                   	 	@foreach($castes as $id => $caste)
                        <option value="{{ $id }}" {{ old('caste_id',$profile->caste_id ?? '') == $id ? 'selected' : '' }}>{{ $caste }}</option>
                    	@endforeach
                	</select>
                	@if($errors->has('caste'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('caste') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.caste_helper') }}</span>
            	</div>
            	<div class="form-group" id="physically_handicapped">
                	<label class="required">{{ trans('cruds.studentDetail.fields.handicapped') }}</label>
                	@foreach(App\StudentProfile::HANDICAPPED_RADIO as $key => $label)
                    	<div class="form-check {{ $errors->has('handicapped') ? 'is-invalid' : '' }}">
                        	<input class="form-check-input phhandicapped" type="radio" id="handicapped_{{ $key }}" name="handicapped" value="{{ $key }}" {{ old('handicapped', $profile->handicapped ?? '') === (string) $key ? 'checked' : '' }} required>
                        	<label class="form-check-label" for="handicapped_{{ $key }}">{{ $label }}</label>
                    	</div>
                	@endforeach
                	@if($errors->has('handicapped'))
                    <div class="invalid-feedback">
                        {{ $errors->first('handicapped') }}
                    </div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.handicapped_helper') }}</span>
            	</div>
            	<div class="form-group" >
                	<label>{{ trans('cruds.studentDetail.fields.single_parent') }}</label>
                	
                	<strong><small>Please select Yes if anyone from your parent(Mother/Father) is not alive</small></strong>
               		 @foreach(App\StudentProfile::SINGLE_PARENT_RADIO as $key => $label)
                    	<div class="form-check {{ $errors->has('single_parent') ? 'is-invalid' : '' }}">
                        	<input class="form-check-input singleparent" type="radio" id="single_parent_{{ $key }}" name="single_parent" value="{{ $key }}" {{ old('single_parent',$profile->single_parent ?? '') === (string) $key ? 'checked' : '' }} required>
                        	<label class="form-check-label" for="single_parent_{{ $key }}">{{ $label }}</label>
                    	</div>
                	@endforeach
                	@if($errors->has('single_parent'))
                    <div class="invalid-feedback">
                        {{ $errors->first('single_parent') }}
                    </div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.single_parent_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="aadharnumber">{{ trans('cruds.studentDetail.fields.aadharnumber') }}</label>
               		 <input class="form-control {{ $errors->has('aadharnumber') ? 'is-invalid' : '' }}" type="number" name="aadharnumber" id="aadharnumber" value="{{ old('aadharnumber',$profile->aadharnumber ?? '') }}" pattern="[0-9]{12}" required>
                	@if($errors->has('aadharnumber'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('aadharnumber') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.aadharnumber_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<button class="btn btn-danger btn-block" type="submit">
                    	Save Details
                	</button>
            	</div>

        </div>

    </div>
    
       
    </div> 

    </form>


<form method="POST" action="{{route('storefamily1')}} " enctype="multipart/form-data">
@csrf
	<input type="hidden" name="familydetails_completed" value="Yes" id="familydetails_completed">
    <div class="card" id="family_details">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseTwo">
            Family Details
            @if(isset($profile->familydetails_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>

        <div id="collapseTwo" class="collapse"  data-parent="#accordion"> 
            <div class="card-body">


            <div class="form-group">
                <label class="required" for="father_name">{{ trans('cruds.studentDetail.fields.father_name') }}</label>
                <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" name="father_name" id="father_name" value="{{ old('father_name', $profile->father_name) }}">
                @if($errors->has('father_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('father_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.father_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.studentDetail.fields.father_edu') }}</label>
                <select class="form-control {{ $errors->has('father_edu') ? 'is-invalid' : '' }}" name="father_edu" id="father_edu">
                    <option value disabled {{ old('father_edu', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::FATHER_EDU_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('father_edu', $profile->father_edu) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('father_edu'))
                    <div class="invalid-feedback">
                        {{ $errors->first('father_edu') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.father_edu_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="father_occupation">{{ trans('cruds.studentDetail.fields.father_occupation') }}</label>
                <input class="form-control {{ $errors->has('father_occupation') ? 'is-invalid' : '' }}" type="text" name="father_occupation" id="father_occupation" value="{{ old('father_occupation',$profile->father_occupation) }}" >
                @if($errors->has('father_occupation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('father_occupation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.father_occupation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mother_name">{{ trans('cruds.studentDetail.fields.mother_name') }}</label>
                <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" type="text" name="mother_name" id="mother_name" value="{{ old('mother_name',$profile->mother_name) }}" >
                @if($errors->has('mother_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mother_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.mother_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.studentDetail.fields.mother_edu') }}</label>
                <select class="form-control {{ $errors->has('mother_edu') ? 'is-invalid' : '' }}" name="mother_edu" id="mother_edu">
                    <option value disabled {{ old('mother_edu',$profile->mother_edu) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::MOTHER_EDU_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mother_edu', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mother_edu'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mother_edu') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.mother_edu_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="parents_mobile">{{ trans('cruds.studentDetail.fields.parents_mobile') }}</label>
                <input class="form-control {{ $errors->has('parents_mobile') ? 'is-invalid' : '' }}" type="text" name="parents_mobile" id="parents_mobile" value="{{ old('parents_mobile', $profile->parents_mobile) }}" >
                @if($errors->has('parents_mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('parents_mobile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.parents_mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="annual_income">{{ trans('cruds.studentDetail.fields.annual_income') }}</label>
                <input class="form-control {{ $errors->has('annual_income') ? 'is-invalid' : '' }}" type="number" name="annual_income" id="annual_income" value="{{ old('annual_income',$profile->annual_income) }}"  >
                @if($errors->has('annual_income'))
                    <div class="invalid-feedback">
                        {{ $errors->first('annual_income') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.annual_income_helper') }}</span>
            </div>
            <div class="form-group">
                	<button class="btn btn-danger btn-block" type="submit">
                    	Save Details
                	</button>
            	</div>
        </div>

        </div>    
        
    </div>
</form>
<form method="POST" action="{{route('storeaddress1')}} " enctype="multipart/form-data">
@csrf
	<input type="hidden" name="communicationdetails_completed" value="Yes">
    <div class="card" id="communication_details">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseThree">
            Communication Details
            @if(isset($profile->communicationdetails_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>


        <div id="collapseThree" class="collapse" data-parent="#accordion">
            <div class="card-body">
            	<div class="form-group">
                	<label class="required" for="current_add">{{ trans('cruds.studentDetail.fields.current_add') }}</label>
                	<input class="form-control {{ $errors->has('current_add') ? 'is-invalid' : '' }}" type="text" name="current_add" id="current_add" value="{{ old('current_add', $profile->current_add) }}" required>
               		 @if($errors->has('current_add'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('current_add') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.current_add_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="current_state">{{ trans('cruds.studentDetail.fields.current_state') }}</label>
                	<select class="form-control {{ $errors->has('current_state') ? 'is-invalid' : '' }}" name="current_state" id="current_state" required>
                    	<option value disabled {{ old('current_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    	@foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        	<option value="{{ $key }}" {{ old('current_state',$profile->current_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    	@endforeach
                	</select>
                	@if($errors->has('current_state'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('current_state') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.current_state_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="current_city">Current District</label>
                	<input class="form-control {{ $errors->has('current_city') ? 'is-invalid' : '' }}" type="text" name="current_city" id="current_city" value="{{ old('current_city',$profile->current_city) }}" required>
                	@if($errors->has('current_city'))
                    	<div class="invalid-feedback">
                       	 {{ $errors->first('current_city') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.current_city_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="pincode">{{ trans('cruds.studentDetail.fields.pincode') }}</label>
                	<input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="number" name="pincode" id="pincode" value="{{ old('pincode', $profile->pincode) }}" step="1" required>
                		@if($errors->has('pincode'))
                    		<div class="invalid-feedback">
                        		{{ $errors->first('pincode') }}
                    		</div>
                		@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.pincode_helper') }}</span>
            	</div>
            	<hr>
            	<div class="form-group">
                	<label>Same as above</label>
                	<input type="checkbox" name="address" id="address">
            	</div>
            	<div class="form-group">
                	<label class="required" for="permanent_add">{{ trans('cruds.studentDetail.fields.permanent_add') }}</label>
                	<input class="form-control {{ $errors->has('permanent_add') ? 'is-invalid' : '' }}" type="text" name="permanent_add" id="permanent_add" value="{{ old('permanent_add', $profile->permanent_add) }}" required>
                	@if($errors->has('permanent_add'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('permanent_add') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.permanent_add_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="permanent_state">{{ trans('cruds.studentDetail.fields.permanent_state') }}</label>
                
                	<select class="form-control {{ $errors->has('permanent_state') ? 'is-invalid' : '' }}" name="permanent_state" id="permanent_state" required>
                    	<option value disabled {{ old('permanent_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    	@foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        	<option value="{{ $key }}" {{ old('permanent_state', $profile->permanent_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    	@endforeach
                	</select>
                	@if($errors->has('permanent_state'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('permanent_state') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.permanent_state_helper') }}</span>
           		</div>
           		<div class="form-group">
                	<label class="required" for="permanent_city">Permanent District</label>
                	<input class="form-control {{ $errors->has('permanent_city') ? 'is-invalid' : '' }}" type="text" name="permanent_city" id="permanent_city" value="{{ old('permanent_city',$profile->permanent_city) }}" required>
                	@if($errors->has('permanent_city'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('permanent_city') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.permanent_city_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="permanent_pincode">{{ trans('cruds.studentDetail.fields.permanent_pincode') }}</label>
                	<input class="form-control {{ $errors->has('permanent_pincode') ? 'is-invalid' : '' }}" type="number" name="permanent_pincode" id="permanent_pincode" value="{{ old('permanent_pincode', $profile->permanent_pincode) }}" step="1" required>
                	@if($errors->has('permanent_pincode'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('permanent_pincode') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.permanent_pincode_helper') }}</span>
            	</div>
            <div class="form-group">
                	<button class="btn btn-danger btn-block" type="submit">
                    	Save Details
                	</button>
            	</div>
            
        </div>
        </div>

        
    </div>
</form>
<form method="POST" action="{{route('storebankdetails1')}} " enctype="multipart/form-data">
@csrf
    <input type="hidden" name="bankdetails_completed" value="Yes">
    <div class="card" id="bank_details">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseFour">
            Bank Details
            @if(isset($profile->bankdetails_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>

        <div id="collapseFour" class="collapse" data-parent="#accordion">
            <div class="card-body">

            <div class="form-group">
                <label class="required" for="account_number">{{ trans('cruds.studentDetail.fields.account_number') }}</label>
                <input class="form-control {{ $errors->has('account_number') ? 'is-invalid' : '' }}" type="number" name="account_number" id="account_number" value="{{ old('account_number',$profile->account_number) }}"  >
                @if($errors->has('account_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('account_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bank_ifsc">{{ trans('cruds.studentDetail.fields.bank_ifsc') }}</label>
                <input class="form-control {{ $errors->has('bank_ifsc') ? 'is-invalid' : '' }}" type="text" name="bank_ifsc" id="bank_ifsc" value="{{ old('bank_ifsc', $profile->bank_ifsc) }}" >
                @if($errors->has('bank_ifsc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_ifsc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.bank_ifsc_helper') }}</span>
            </div>
            <div class="form-group">
                	<button class="btn btn-danger btn-block" type="submit">
                    	Save Details
                	</button>
            	</div>
        </div>

        </div>
    </div>
</form>
<form method="POST" action=" {{ route('storecoursedetails1')}}" enctype="multipart/form-data">
            @csrf
	<input type="hidden" name="currentcoursedetails_completed" value="Yes">
    <div class="card" id="course_details">
        <div class="card-header collapsed card-link"  data-toggle="collapse" data-target="#collapseFive">
            Current Course Details
            @if(isset($profile->currentcoursedetails_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>

        <div id="collapseFive" class="collapse" data-parent="#accordion">
            <div class="card-body">
                
            <div class="form-group">
                <label for="course_type_id">Course Type</label>
               
               <select name="course_type_id" class="form-control " id="course_type_id" disabled required>
                                <option value disabled {{ old('course_type_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach($course_types as $id => $course_type)
                                <option value="{{$course_type->id}}" {{ old('course_type_id',$profile->course_type_id ?? '') == $course_type->id ? 'selected' : ''}}>{{$course_type->course_type_name}}</option>
                        
                                @endforeach
                            </select>

               
              
                    
            </div>
            
            	<div class="form-group">
                	<label for="student_course_name_id">Course Name</label>
                	<select name="student_course_name_id"  id="student_course_name_id" class="form-control select2"  required>
                        <option value disabled {{ old('student_course_name_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    	@foreach($studentcourse as $id => $studentcourses)
                        	<option value="{{$id}}"{{ old('student_course_name_id',$profile->student_course_name_id ?? '') == $id ? 'selected' : ''}}>{{$studentcourses}}</option>
                        
                    	@endforeach
                   

                	</select>
                    
            	</div>
                
                
            	<div class="form-group" >
                	<label for="course_name_id">Specialization</label>
                	<select name="course_name_id"  id="course_name_id" class="form-control select2" required>
                        
                   	 	@foreach($course as $id => $courses)
                       	 <option value="{{$id}}"{{ old('course_name_id',$profile->course_name_id) == $id ? 'selected' : ''}}>{{$courses}}</option>
                        
                    	@endforeach

                	</select>
                    
            	</div>
                
            	<div class="form-group" id="current_year" style="display: none;">
                <label  for="current_year">Current Year</label>
                    <select name="current_year" id="current_year" class="form-control ">
                        <option value disabled {{ old('current_year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\StudentProfile::CURRENT_YEAR as $key => $label)
                            <option value="{{ $key }}" {{ old('religion', $profile->current_year) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    
                    </select>
                </div>

            	<div class="form-group">
                	<label class="required" for="current_inst_name" id="current_inst_name_label">{{ trans('cruds.studentDetail.fields.current_inst_name') }}</label>
                	<input class="form-control {{ $errors->has('current_inst_name') ? 'is-invalid' : '' }}" type="text" name="current_inst_name" id="current_inst_name" value="{{ old('current_inst_name',$profile->current_inst_name) }}" required>
                	@if($errors->has('current_inst_name'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('current_inst_name') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ 	trans('cruds.studentDetail.fields.current_inst_name_helper') }}</span>
            	</div>
            	<div class="form-group">
                	<label class="required" for="inst_address" id="inst_address_label">Address of Institute</label>
                	<input class="form-control {{ $errors->has('inst_address') ? 'is-invalid' : '' }}" type="text" name="inst_address" id="inst_address" value="{{ old('inst_address', $profile->current_inst_name) }}" required>
               		 @if($errors->has('inst_address'))
                    	<div class="invalid-feedback">
                        	{{ $errors->first('inst_address') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.inst_address_helper') }}</span>
            	</div>
            	<div class="form-group">
            		<label class="required" for="course_start" id="course_start_label">Course Starting Year/Admission Year</label>
                		<input class="form-control date {{ $errors->has('course_start') ? 'is-invalid' : '' }}" type="text" name="course_start" id="course_start" value="{{ old('course_start',$profile->course_start) }}" required>
                			@if($errors->has('course_start'))
                    		<div class="invalid-feedback">
                        		{{ $errors->first('course_start') }}
                    		</div>
                			@endif
                	
            	</div>
            	<div class="form-group">
                	<label class="required" for="tution_fees" id="tution_fees_label">Tution Fees</label>
                	<small id="fees_label">Enter Amount As Written on Fees Reciept/Fees Structure</small>
                	<input class="form-control {{ $errors->has('tution_fees') ? 'is-invalid' : '' }}" type="number" name="tution_fees" id="tution_fees" value="{{ old('tution_fees', $profile->tution_fees) }}" step="1" required>
                	@if($errors->has('tution_fees'))
                    	<div class="invalid-feedback">
                        {{ $errors->first('tution_fees') }}
                    	</div>
                	@endif
                	<span class="help-block">{{ trans('cruds.studentDetail.fields.tution_fees_helper') }}</span>
            	</div>
                <div class="form-group">
                    <label class="required" for="non_tution_fees" id="tution_fees_label">Non Tution Fees</label>
                    <small id="fees_label">Enter Amount As Written on Fees Reciept/Fees Structure</small>
                    <input class="form-control {{ $errors->has('non_tution_fees') ? 'is-invalid' : '' }}" type="number" name="non_tution_fees" id="non_tution_fees" value="{{ old('non_tution_fees', $profile->non_tution_fees) }}" step="1" required>
                    @if($errors->has('tution_fees'))
                        <div class="invalid-feedback">
                        {{ $errors->first('non_tution_fees') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.tution_fees_helper') }}</span>
                </div>
                <div class="form-group">
                	<button class="btn btn-danger btn-block" type="submit">
                    	Save Details
                	</button>
            	</div>
                
            
        </div>
    </div>   
    </div>
</form>
<form method="POST" action="{{ route('storessc1')}}" enctype="multipart/form-data">
            @csrf
     <input type="hidden" name="class10_details_completed" value="Yes">
    <div class="card " id="class10_details" style="display: none;">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseSix">
            Class 10 Details
            @if(isset($profile->class10_details_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>

        <div id="collapseSix" class="collapse" data-parent="#accordion"> 
            <div class="card-body">

            <div class="form-group ">
                <label class="required" for="class_10_school_name">{{ trans('cruds.studentDetail.fields.class_10_school_name') }}</label>
                <input class="form-control {{ $errors->has('class_10_school_name') ? 'is-invalid' : '' }}" type="text" name="class_10_school_name" id="class_10_school_name" value="{{ old('class_10_school_name', $profile->class_10_school_name) }}" required>
                @if($errors->has('class_10_school_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_10_school_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_10_school_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="class_10_state">{{ trans('cruds.studentDetail.fields.class_10_state') }}</label>
                

                <select class="form-control {{ $errors->has('class_10_state') ? 'is-invalid' : '' }}" name="class_10_state" id="class_10_state" required>
                    <option value disabled {{ old('class_10_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('class_10_state', $profile->class_10_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                @if($errors->has('class_10_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_10_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_10_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="school_passing">{{ trans('cruds.studentDetail.fields.school_passing') }}</label>
                <input class="form-control date {{ $errors->has('school_passing') ? 'is-invalid' : '' }}" type="text" name="school_passing" id="school_passing" value="{{ old('school_passing',$profile->school_passing) }}" required>
                @if($errors->has('school_passing'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_passing') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_passing_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">Scoring System</label>
                <input type="radio" name="ssc_scoring" value="marks" id="ssc_marks" >
                Marks
                <input type="radio" name="ssc_scoring" value="cgpa" id="ssc_cgpa" > CGPA
            </div>
            <div class="form-group">
                <label class="required" for="school_marks_obtained" style="display: none;" id="school_obtained">{{ trans('cruds.studentDetail.fields.school_marks_obtained') }}</label>
                <input class="form-control {{ $errors->has('school_marks_obtained') ? 'is-invalid' : '' }}" type="number" name="school_marks_obtained" id="school_marks_obtained" value="{{ old('school_marks_obtained',$profile->school_marks_obtained) }}" style="display: none;" >
                @if($errors->has('school_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_marks_obtained') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_obtained_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="school_marks_total" style="display: none;" id="school_total">{{ trans('cruds.studentDetail.fields.school_marks_total') }}</label>
                <input class="form-control {{ $errors->has('school_marks_total') ? 'is-invalid' : '' }}" type="number" name="school_marks_total" id="school_marks_total" value="{{ old('school_marks_total',$profile->school_marks_total) }}" style="display: none;" >
                @if($errors->has('school_marks_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_marks_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label  for="class10_obtained" id="school_cgpa_obtained" style="display: none;" class="required">Class 10 CGPA Obtained</label>
                <input class="form-control {{ $errors->has('cgpa_school_marks_obtained') ? 'is-invalid' : '' }}" type="text" name="cgpa_school_marks_obtained" id="cgpa_school_marks_obtained" value="{{ old('cgpa_school_marks_obtained',$profile->cgpa_school_marks_obtained) }}" style="display: none;" step="0.01" min="0" max="10"  >
                @if($errors->has('cgpa_school_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cgpa_school_marks_obtained') }}
                    </div>
                @endif
                
            </div>
            <div class="form-group">
                <label  for="class10_total" id="school_cgpa_total" style="display: none;" class="required"> Class 10 Total CGPA </label>
                <input class="form-control {{ $errors->has('cgpa_school_marks_total ') ? 'is-invalid' : '' }}" type="text" name="cgpa_school_marks_total" id="cgpa_school_marks_total"  style="display: none;" step="0.01" min="0" max="10" >
                @if($errors->has('cgpa_school_marks_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cgpa_school_marks_total  ') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">Percentage</label>
              
                <input type="text" name="school_percentage" class="form-control" id="ssc_percentage" value="{{old('ssc_percentage',$profile->school_percentage)}}" required>
                
            </div>
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                Save Details
                </button>
            </div>
            



        </div>

        </div>
    </div>
    <div class="card " id="class12_details" style="display: none;">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseSeven">
           
    

        
          Class 12 Details/ Diploma Details
       <i class="fa fa-plus float-right" aria-hidden="true"></i>
      
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <label>Which of following course have you completed</label>
            <input type="radio" name="class12_appeared" value="YES" id="class12_appeared_yes">Class 12
            <input type="radio" name="class12_appeared" value="No" id="class12_appeared_no">Diploma
            <input type="radio" name="class12_appeared" value="Both" id="class12_appeared_both">Both
            <form method="POST" action=" {{ route('storeclass12')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="class12_details_completed" value="Yes">
            <div class="form-group ">
                <label for="class_12_clg_name" class="required" id="class_12_clg_name_label" style="display:none;">{{ trans('cruds.studentDetail.fields.class_12_clg_name') }}</label>
                <input class="form-control {{ $errors->has('class_12_clg_name') ? 'is-invalid' : '' }}" type="text" name="class_12_clg_name" id="class_12_clg_name" value="{{ old('class_12_clg_name',$profile->class_12_clg_name) }}" style="display:none;">
                @if($errors->has('class_12_clg_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_12_clg_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_12_clg_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_12_state" class="required" id="class_12_state_label" style="display:none;">{{ trans('cruds.studentDetail.fields.class_12_state') }}</label>
                
                <select class="form-control {{ $errors->has('class_12_state') ? 'is-invalid' : '' }}" name="class_12_state" id="class_12_state" style="display:none;" >
                    <option value disabled {{ old('class_12_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('class_12_state', $profile->class_12_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                @if($errors->has('class_12_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_12_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_12_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_12_passing_yeat" class="required" id="class_12_passing_yeat_label" style="display:none;">{{ trans('cruds.studentDetail.fields.class_12_passing_yeat') }}</label>
                <input class="form-control date {{ $errors->has('class_12_passing_yeat') ? 'is-invalid' : '' }}" type="text" name="class_12_passing_yeat" id="class_12_passing_yeat" value="{{ old('class_12_passing_yeat', $profile->class_12_passing_yeat) }}" style="display:none;">
                @if($errors->has('class_12_passing_yeat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_12_passing_yeat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_12_passing_yeat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" id="scoring_system" style="display:none;">Scoring System</label>
                <input type="radio" name="hsc_scoring" value="marks" id="hsc_marks" style="display:none;">
                <label id="hsc_marks_label" style="display:none;">Marks</label>
                <input type="radio" name="hsc_scoring" style="display:none;" value="cgpa" id="hsc_cgpa"> <label id="hsc_cgpa_label" style="display:none;">CGPA</label> 
            </div>
            <div class="form-group">
                <label for="class_12_marks_obtained"  style="display: none;" class="required" id="class_12_marks_obtained_label">{{ trans('cruds.studentDetail.fields.class_12_marks_obtained') }}</label>
                <input class="form-control {{ $errors->has('class_12_marks_obtained') ? 'is-invalid' : '' }}" type="number" name="class_12_marks_obtained" id="class_12_marks_obtained" value="{{ old('class_12_marks_obtained', $profile->class_12_marks_obtained) }}" step="1" style="display: none;">
                @if($errors->has('class_12_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_12_marks_obtained') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_12_marks_obtained_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_12_out_of_total_marks"  style="display: none;" id="class_12_out_of_total_marks_label">{{ trans('cruds.studentDetail.fields.class_12_out_of_total_marks') }}</label>
                <input class="form-control {{ $errors->has('class_12_out_of_total_marks') ? 'is-invalid' : '' }}" type="number" name="class_12_out_of_total_marks" id="class_12_out_of_total_marks" value="{{ old('class_12_out_of_total_marks',$profile->class_12_out_of_total_marks) }}" step="1" style="display: none;">
                @if($errors->has('class_12_out_of_total_marks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_12_out_of_total_marks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.class_12_out_of_total_marks_helper') }}</span>
            </div>
            <div class="form-group">
                <label  for="cgpa_previous_marks_obtained" id="hsc_cgpa_obtained" style="display: none;" >Class 12 CGPA Obtained</label>
                <input class="form-control {{ $errors->has('previous_marks_obtained') ? 'is-invalid' : '' }}" type="text" name="cgpa_class_12_marks_obtained" id="cgpa_class_12_marks_obtained" value="{{ old('cgpa_class_12_marks_obtained', $profile->cgpa_class_12_marks_obtained) }}" style="display: none;" step="0.01" min="0" max="10"  >
                @if($errors->has('previous_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('previous_marks_obtained') }}
                    </div>
                @endif
                
            </div>
            <div class="form-group">
                <label  for="cgpa_previous_marks_total" id="hsc_cgpa_total_label" style="display: none;">Class 12 Total CGPA </label>
                <input class="form-control {{ $errors->has('previous_marks_total') ? 'is-invalid' : '' }}" type="text" name="cgpa_class_12_marks_total" id="cgpa_class_12_marks_total"   style="display: none;" min="0" max="10" >
                @if($errors->has('cgpa_previous_marks_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cgpa_previous_marks_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" id="hsc_percentage_label" style="display:none;">Percentage</label>

               
                <input type="text" name="class_12_percentage" id="hsc_percentage" class="form-control" value="{{ old('hsc_percentage', $profile->class_12_percentage ?? '') }}" style="display: none;" readonly>
            </div>
            <div class="form-group" >
                <button class="btn btn-danger" type="submit" id="hsc_save_details" style="display:none;">
                Save Details
                </button>
            </div>
        </form>
        <form method="POST" action=" {{ route('storediploma')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="diploma_details_completed" value="Yes">
            <div class="form-group ">
                <label for="diploma_clg_name" class="required" id="diploma_clg_name_label" style="display:none;">{{ trans('cruds.studentDetail.fields.diploma_clg_name') }}</label>
                <input class="form-control {{ $errors->has('diploma_clg_name') ? 'is-invalid' : '' }}" type="text" name="diploma_clg_name" id="diploma_clg_name" value="{{ old('diploma_clg_name', $profile->diploma_clg_name) }}" style="display:none;">
                @if($errors->has('diploma_clg_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diploma_clg_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.diploma_clg_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="diploma_state" class="required" id="diploma_state_label" style="display:none;">{{ trans('cruds.studentDetail.fields.diploma_state') }}</label>
                
                <select class="form-control {{ $errors->has('diploma_state') ? 'is-invalid' : '' }}" name="diploma_state" id="diploma_state"  style="display:none;">
                    <option value disabled {{ old('diploma_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('diploma_state', $profile->diploma_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('diploma_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diploma_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.diploma_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="diploma_passing_year" class="required" id="diploma_passing_year_label" style="display:none;">{{ trans('cruds.studentDetail.fields.diploma_passing_year') }}</label>
                <input class="form-control date {{ $errors->has('diploma_passing_year') ? 'is-invalid' : '' }}" type="text" name="diploma_passing_year" id="diploma_passing_year" value="{{ old('diploma_passing_year', $profile->diploma_passing_year) }}" style="display:none;">
                @if($errors->has('diploma_passing_year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diploma_passing_year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.diploma_passing_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" id="diploma_scoring" style="display:none;">Scoring System</label>
                <input type="radio" name="diploma_scoring" value="marks" id="diploma_marks" style="display:none;">
                <label id="diploma_marks_label" style="display:none;">Marks</label>
                <input type="radio" name="diploma_scoring" value="cgpa" id="diploma_cgpa" style="display:none;" ><label id="diploma_cgpa_label" style="display:none;">CGPA </label>
            </div>
            <div class="form-group">
                <label for="diploma_total_marks_obtained" id="diploma_obtained" class="required" style="display: none;">{{ trans('cruds.studentDetail.fields.diploma_total_marks_obtained') }}</label>
                <input class="form-control {{ $errors->has('diploma_total_marks_obtained') ? 'is-invalid' : '' }}" type="number" name="diploma_total_marks_obtained" id="diploma_total_marks_obtained" value="{{ old('diploma_total_marks_obtained', $profile->diploma_total_marks_obtained) }}" style="display: none;">
                @if($errors->has('diploma_total_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diploma_total_marks_obtained') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.diploma_total_marks_obtained_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="diploma_out_of_total_marks" id="diploma_total" class="required" style="display: none;">{{ trans('cruds.studentDetail.fields.diploma_out_of_total_marks') }}</label>
                <input class="form-control {{ $errors->has('diploma_out_of_total_marks') ? 'is-invalid' : '' }}" type="number" name="diploma_out_of_total_marks" id="diploma_out_of_total_marks" value="{{ old('diploma_out_of_total_marks',$profile->diploma_out_of_total_marks) }}" style="display: none;">
                @if($errors->has('diploma_out_of_total_marks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diploma_out_of_total_marks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.diploma_out_of_total_marks_helper') }}</span>
            </div>
            <div class="form-group">
                <label  for="cgpa_previous_marks_obtained" id="diploma_cgpa_obtained" style="display: none;" class="required"> CGPA Obtained</label>
                <input class="form-control {{ $errors->has('previous_marks_obtained') ? 'is-invalid' : '' }}" type="text" name="cgpa_diploma_marks_obtained" id="cgpa_diploma_marks_obtained" value="{{ old('cgpa_diploma_marks_obtained', $profile->cgpa_diploma_marks_obtained) }}" style="display: none;" step="0.01" min="0" max="10"  >
                @if($errors->has('previous_marks_obtained'))
                    <div class="invalid-feedback">
                        {{ $errors->first('previous_marks_obtained') }}
                    </div>
                @endif
                
            </div>
            <div class="form-group">
                <label  for="cgpa_previous_marks_total" id="diploma_cgpa_total" style="display: none;" class="required">Total CGPA </label>
                <input class="form-control {{ $errors->has('previous_marks_total') ? 'is-invalid' : '' }}" type="text" name="cgpa_diploma_marks_total" id="cgpa_diploma_marks_total"    step="0.01" min="0" max="10"  style="display: none;">
                @if($errors->has('cgpa_diploma_marks_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cgpa_diploma_marks_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_total_helper') }}</span>
            </div>
            <div class="form-group">
            <label id="diploma_percentage_label" style="display:none;">Percentage</label>
            @if(empty($profile->diploma_percentage))
            <input type="text" name="diploma_percentage" id="diploma_percentage"  class="form-control" readonly style="display:none">  
            @else
            <input type="text" name="diploma_percentage" id="diploma_percentage"  class="form-control"  value="{{$profile->diploma_percentage}}" style="display:none" >
            @endif
            </div>
            
            <div class="form-group" >
                <button class="btn btn-danger" type="submit" style="display:none;" id="diploma_submit">
                Save Details
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>

<form method="POST" action=" {{ route('storegrad')}}" enctype="multipart/form-data">
            @csrf
    <input type="hidden" name="graduation_details_completed" value="Yes">
    <div class="card" id="graduation_details"  style="display: none;">
        <div class="card-header collapsed card-link" data-toggle="collapse" data-target="#collapseNine">
            Graduation Details
            @if(isset($profile->graduation_details_completed))
                <i class="fa fa-check-circle" style="font-size:24px;color:green; "></i>
            @else
            <span class="badge badge-danger">Incomplete Details</span>
            @endif
            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </div>

        <div id="collapseNine"  class="collapse" data-parent="#accordion">
            <div class="card-body">
                <div class="form-group ">
                    <label for="grad_clg_name" class="required">{{ trans('cruds.studentDetail.fields.grad_clg_name') }}</label>
                    <input class="form-control {{ $errors->has('grad_clg_name') ? 'is-invalid' : '' }}" type="text" name="grad_clg_name" id="grad_clg_name" value="{{ old('grad_clg_name', $profile->grad_clg_name) }}">
                    @if($errors->has('grad_clg_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('grad_clg_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.grad_clg_name_helper') }}</span>
            </div>
            <div class="form-group">
                    <label for="grad_state" class="required">{{ trans('cruds.studentDetail.fields.grad_state') }}</label>
                    
                    <select class="form-control {{ $errors->has('grad_state') ? 'is-invalid' : '' }}" name="grad_state" id="grad_state" required>
                    <option value disabled {{ old('grad_state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\StudentProfile::STATE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('grad_state', $profile->grad_state) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                    @if($errors->has('grad_state'))
                        <div class="invalid-feedback">
                        {{ $errors->first('grad_state') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.grad_state_helper') }}</span>
            </div>
            <div class="form-group">
                    <label for="grad_passing_year" class="required">{{ trans('cruds.studentDetail.fields.grad_passing_year') }}</label>
                    <input class="form-control date {{ $errors->has('grad_passing_year') ? 'is-invalid' : '' }}" type="text" name="grad_passing_year" id="grad_passing_year" value="{{ old('grad_passing_year',$profile->grad_passing_year) }}" required>
                    @if($errors->has('grad_passing_year'))
                        <div class="invalid-feedback">
                            {{ $errors->first('grad_passing_year') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.grad_passing_year_helper') }}</span>
            </div>
            <div class="form-group">
                    <label class="required">Scoring System</label>
                    <input type="radio" name="grad_scoring" value="marks" id="grad_marks">
                    Marks
                    <input type="radio" name="grad_scoring" value="cgpa" id="grad_cgpa"> CGPA
            </div>
            
            <div class="form-group">
                    <label for="grad_total_marks" id="grad_obtained" class="required" style="display: none;">{{ trans('cruds.studentDetail.fields.grad_total_marks')   }}</label>
                    <input class="form-control {{ $errors->has('grad_total_marks') ? 'is-invalid' : '' }}"  type="number" name="grad_total_marks" id="grad_total_marks" value="{{ old('grad_total_marks',$profile->grad_total_marks) }}" style="display:none;">
                    @if($errors->has('grad_total_marks'))
                        <div class="invalid-feedback">
                            {{ $errors->first('grad_total_marks') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.grad_total_marks_helper') }}</span>
            </div>
            <div class="form-group">
                    <label for="grad_out_of_total_marks" id="grad_total" style="display: none;" class="required" >{{ trans('cruds.studentDetail.fields.grad_out_of_total_marks') }}</label>
                    <input class="form-control {{ $errors->has('grad_out_of_total_marks') ? 'is-invalid' : '' }}" type="number" name="grad_out_of_total_marks" id="grad_out_of_total_marks"     value="{{ old('grad_out_of_total_marks',$profile->grad_out_of_total_marks) }}" style="display: none;">
                    @if($errors->has('grad_out_of_total_marks'))
                        <div class="invalid-feedback">
                            {{ $errors->first('grad_out_of_total_marks') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.grad_out_of_total_marks_helper') }}</span>
            </div>
            <div class="form-group">
                    <label  for="grad_cgpa_obtained" id="grad_cgpa_obtained" style="display: none;"> CGPA Obtained</label>
                    <input class="form-control {{ $errors->has('cgpa_grad_marks_obtained') ? 'is-invalid' : '' }}" type="text" name="cgpa_grad_marks_obtained" id="cgpa_grad_marks_obtained" value="{{ old('cgpa_grad_marks_obtained', $profile->cgpa_grad_marks_obtained) }}" style="display: none;" step="0.01" min="0" max="10"  >
                    @if($errors->has('previous_marks_obtained'))
                        <div class="invalid-feedback">
                            {{ $errors->first('previous_marks_obtained') }}
                        </div>
                    @endif
                
            </div>
            <div class="form-group">
                    <label  for="cgpa_previous_marks_total" id="grad_cgpa_total" style="display: none;  ">Total CGPA </label>
                    <input class="form-control {{ $errors->has('cgpa_grad_marks_total') ? 'is-invalid' : '' }}" type="text" name="cgpa_grad_marks_total" id="cgpa_grad_marks_total"   style="display: none;" step="0.01" min="0" max="10" >
                    @if($errors->has('cgpa_grad_marks_total'))
                        <div class="invalid-feedback">
                        {{ $errors->first('cgpa_grad_marks_total') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentDetail.fields.school_marks_total_helper') }}</span>
            </div>
            <div class="form-group">
                <label>Percentage</label>
                
                <input type="text" name="grad_percentage" id="grad_percentage" class="form-control"
                value="{{old('grad_percentage',$profile->grad_percentage ?? '')}}" required>

            </div>
             <div class="form-group">
                <button class="btn btn-danger" type="submit">
                Save Details
                </button>
            </div>
                
            </div>
        </div>

    </div>
    
      


    </div>     

</form>



<div class="form-group">
  
   <a href="{{route('applicationwindow2',['id' => $scholarship_id])}}" onclick="return validateForm()" class="btn btn-danger">Proceed to Next Section</a>

 
</div>



    
</div>    




@endsection

@section('scripts')
<script>
    /*
    function validateForm() {
        // Check if required fields contain null values
        
        //var familydetails_completed = document.getElementById('familydetails_completed').value;
        var course_type_id = "{{$profile->course_type_id}}";
        alert(course_type_id);
        var personalDetailsCompleted = "{{$profile->personaldetails_completed}}";
        var familydetails_completed="{{$profile->familydetails_completed}}";
        var communicationDetailsCompleted="{{$profile->communicationdetails_completed}}";
        var bankdetails_completed="{{$profile->bankdetails_completed}}";
        var currentcoursedetails_completed="{{$profile->currentcoursedetails_completed}}"
        var class10_details_completed="{{$profile->class10_details_completed}}";
        var class12_details_completed="{{$profile->class12_details_completed}}";
        var diploma_details_completed="{{$profile->diploma_details_completed}}";
        var graduation_details_completed="{{$profile->graduation_details_completed}}";

        if (course_type_id==1) {
            if (!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted) {
            // Show prompt to complete required fields
                    alert('Please complete all required fields.');
                    return false; // Prevent form submission
            }else
            {
                        return true;
            }
        }
        else if(course_type_id==2 || course_type_id==3){
            if (!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) {
            // Show prompt to complete required fields
                    alert('Please complete all required fields.');
                    return false; // Prevent form submission
            }else
            {
                        return true;
            }   
        }
        else if(course_type_id==4 || course_type_id==6 || course_type_id==7 || course_type_id==8){
            if ((!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) && !(class12_details_completed || diploma_details_completed)) {
                // Show prompt to complete the necessary details
                alert("Please complete the required details before submitting.");
                return false; // Prevent form submission
            }
            else
            {
                        return true;
            }
        else if(course_type_id==5){
            if ((!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) && !(class12_details_completed || diploma_details_completed) || ) {
                // Show prompt to complete the necessary details
                alert("Please complete the required details before submitting.");
                return false; // Prevent form submission
            }
            else
            {
                        return true;
            }   
        }
        else{
            alert('Course Details Not Found');
            return false;
        }
        

        //alert(familydetails_completed);
       // if (!familydetails_completed) {
          // alert('Family Details Pending');
        //}else{
            //alert('Family Details Completed');
        //}

        //var communicationDetailsCompleted = document.getElementsByName('email')[0].value !== '';
        //var bankDetailsCompleted = document.getElementsByName('account_number')[0].value !== '';
        //var currentCourseDetailsCompleted = document.getElementsByName('course_name')[0].value !== '';

        
        //alert('Hi');
        //return true; // Allow form submission
    }*/
    function validateForm() {
    // Check if required fields contain null values
    var course_type_id = "{{$profile->course_type_id}}";
    
    var personalDetailsCompleted = "{{$profile->personaldetails_completed}}";
    var familydetails_completed = "{{$profile->familydetails_completed}}";
    var communicationDetailsCompleted = "{{$profile->communicationdetails_completed}}";
    var bankdetails_completed = "{{$profile->bankdetails_completed}}";
    var currentCourseDetailsCompleted = "{{$profile->currentcoursedetails_completed}}";
    var class10_details_completed = "{{$profile->class10_details_completed}}";
    var class12_details_completed = "{{$profile->class12_details_completed}}";
    var diploma_details_completed = "{{$profile->diploma_details_completed}}";
    var graduation_details_completed = "{{$profile->graduation_details_completed}}";

    if (course_type_id == 1) {
        if (!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted) {
            // Show prompt to complete required fields
            
            return false; // Prevent form submission
        } else {
            return true;
        }
    } else if (course_type_id == 2 || course_type_id == 3) {
        if (!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) {
            // Show prompt to complete required fields
            alert('Please complete all required fields.');
            return false; // Prevent form submission
        } else {
            return true;
        }
    } else if (course_type_id == 4 || course_type_id == 6 || course_type_id == 7 || course_type_id == 8) {
        if ((!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) && !(class12_details_completed || diploma_details_completed)) {
            // Show prompt to complete the necessary details
            alert("Please complete the required details before submitting.");
            return false; // Prevent form submission
        } else {
            return true;
        }
    } else if (course_type_id == 5) {
        if ((!personalDetailsCompleted || !familydetails_completed || !communicationDetailsCompleted || !bankdetails_completed || !currentCourseDetailsCompleted || !class10_details_completed) && !(class12_details_completed || diploma_details_completed)) {
            // Show prompt to complete the necessary details
            alert("Please complete the required details before submitting.");
            return false; // Prevent form submission
        } else {
            return true;
        }
    } else {
        alert('Course Details Not Found');
        return false;
    }
}

</script>

<script type="text/javascript">
     $("#course_type_id").change(function(){
            $.ajax({
                url: "{{ route('getcourse') }}?course_type_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#course_name_id').html(data.html);
                    
                    
                }
            });
        });
</script>
<script type="text/javascript">
     $("#course_type_id").change(function(){
            $.ajax({
                url: "{{ route('getstudentcourse') }}?course_type_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#student_course_name_id').html(data.html);
                    
                    
                }
            });
        });
</script>
<script type="text/javascript">
    $("#course_type_id").on("change",fun_showdetails);
    function fun_showdetails()
    {
    	var select_status=$("#course_type_id").val();

    	if (select_status>2 && select_status<8) {
    		$('#current_year').show();
    	}
    	else
    	{
    		$('#current_year').hide();
    	}
    }
 </script>
 <script type="text/javascript">
 	
    $("#class10_passed_yes").on("click",ssc_passed_yes);
    $("#class10_passed_no").on("click",ssc_passed_no);
    function ssc_passed_yes()
    {
        //alert('yes');

        
        document.getElementById("current_inst_name").removeAttribute("required");
        document.getElementById("inst_address").removeAttribute("required");
        document.getElementById("course_start").removeAttribute("required");
        document.getElementById("tution_fees").removeAttribute("required");
        document.getElementById("class12_passed_yes").removeAttribute("required");
        document.getElementById("diploma_passed_yes").removeAttribute("required");
       
        $('#current_inst_name').hide();
        $('#inst_address').hide();
        $('#course_start').hide();
        $('#tution_fees').hide();
        $('#current_inst_name_label').hide();
        $('#inst_address_label').hide();
        $('#course_start_label').hide();
        $('#tution_fees_label').hide();
        $('#fees_label').hide();
        $('#class12_passed_yes').hide();
        $('#class12_passed_no').hide();
        $('#class12_passed_que').hide();
        $('#class12_no_label').hide();
        $('#class12_yes_label').hide();
        $('#diploma_passed_que').hide();
        $('#diploma_no_label').hide();
       
        $('#diploma_passed_yes').hide();
        $('#diploma_passed_no').hide();
        $('#diploma_yes_label').hide();
           
       //$('#course_name_id').removeClass('select2');
        
        //$('#course_type_id').val('2');
        $("#course_type_id option[value=2]").attr('selected','selected');
         
          $.ajax({
                url: "{{ route('setcourse') }}?course_name_id=" +535,
                method: 'GET',
                success: function(data) {
                    $('#course_name_id').html(data.html);
                    
                    
                }
            });

        $.ajax({
                url: "{{ route('setstudentcourse') }}?student_course_name_id=" +135,
                method: 'GET',
                success: function(data) {
                    $('#student_course_name_id').html(data.html);
                    
                    
                }
            });
       
        
            
       


        //var abc=$('#hidden_course_type_id').val();
        //alert(abc);
        //$("#course_name_id option[value=538]").attr('selected','selected');
              
       
      
        

    }
    function ssc_passed_no()
    {
        
        
       $('#current_inst_name').show();
        $('#inst_address').show();
        $('#course_start').show();
        $('#tution_fees').show();
        $('#current_inst_name_label').show();
        $('#inst_address_label').show();
        $('#course_start_label').show();
        $('#tution_fees_label').show();
        $('#fees_label').show();
        $('#class12_passed_yes').show();
        $('#class12_passed_no').show();
        $('#class12_passed_que').show();
        $('#class12_no_label').show();
        $('#class12_yes_label').show();
        $('#diploma_passed_que').show();
        $('#diploma_no_label').show();
       
        $('#diploma_passed_yes').show();
        $('#diploma_passed_no').show();
        $('#diploma_yes_label').show();
        document.getElementById("current_inst_name").setAttribute("required","");
        document.getElementById("inst_address").setAttribute("required","");
        document.getElementById("course_start").setAttribute("required","");
        document.getElementById("tution_fees").setAttribute("required","");
        document.getElementById("class12_passed_yes").setAttribute("required","");
        document.getElementById("diploma_passed_yes").setAttribute("required","");
        document.getElementById("course_type_id").setAttribute("required","");
        document.getElementById("course_name_id").setAttribute("required","");
        document.getElementById("student_course_name_id").setAttribute("required","");

        

        //document.getElementById("course_name_id").classList.add('select2');
        
       

        $("#course_type_id")[0].selectedIndex = 0;
        $("#course_name_id")[0].selectedIndex = 0;
        $("#student_course_name_id")[0].selectedIndex = 0;
    }
    $("#class12_passed_yes").on("change",class12_passed_yes);
    $("#class12_passed_no").on("change",class12_passed_no);
    function class12_passed_yes()
    {
       

        
        document.getElementById("current_inst_name").removeAttribute("required");
        document.getElementById("inst_address").removeAttribute("required");
        document.getElementById("course_start").removeAttribute("required");
        document.getElementById("tution_fees").removeAttribute("required");
        document.getElementById("diploma_passed_yes").removeAttribute("required");
        $('#current_inst_name').hide();
        $('#inst_address').hide();
        $('#course_start').hide();
        $('#tution_fees').hide();
        $('#current_inst_name_label').hide();
        $('#inst_address_label').hide();
        $('#course_start_label').hide();
        $('#tution_fees_label').hide();
        $('#fees_label').hide();

        
        $('#class10_passed_que').hide();
        $('#class10_passed_yes').hide();
        $('#class10_passed_no').hide();
        $('#class10_no_label').hide();
        $('#class10_yes_label').hide();
        
        $('#class10_passed_label_no').hide();
        $('#class10_passed_label_yes').hide();

       
        $('#diploma_passed_que').hide();
        $('#diploma_no_label').hide();
       
        $('#diploma_passed_yes').hide();
        $('#diploma_passed_no').hide();
        $('#diploma_yes_label').hide();

         //$('#course_type_id').val('2');
        $("#course_type_id option[value=4]").attr('selected','selected');

          $.ajax({
                url: "{{ route('setcourse') }}?course_name_id=" +534,
                method: 'GET',
                success: function(data) {
                    $('#course_name_id').html(data.html);
                    
                    
                }
            });

        $.ajax({
                url: "{{ route('setstudentcourse') }}?student_course_name_id=" +136,
                method: 'GET',
                success: function(data) {
                    $('#student_course_name_id').html(data.html);
                    
                    
                }
            });
       
        //$("#course_name_id option[value=539]").attr('selected','selected');
        
        //$("#student_course_name_id option[value=136]").attr('selected','selected');

       

       
        
        
        
        
        
    }
     function class12_passed_no()
    {
        
        
       $('#current_inst_name').show();
        $('#inst_address').show();
        $('#course_start').show();
        $('#tution_fees').show();
        $('#current_inst_name_label').show();
        $('#inst_address_label').show();
        $('#course_start_label').show();
        $('#tution_fees_label').show();
        $('#fees_label').show();

        $('#class10_passed_yes').show();
        $('#class10_passed_no').show();
        $('#class10_passed_que').show();
        $('#class10_no_label').show();
        $('#class10_yes_label').show();
        $('#class10_passed_label_no').show();
        $('#class10_passed_label_yes').show();

        $('#diploma_passed_que').show();
        $('#diploma_no_label').show();
       
        $('#diploma_passed_yes').show();
        $('#diploma_passed_no').show();
        $('#diploma_yes_label').show();
       
        document.getElementById("current_inst_name").setAttribute("required","");
        document.getElementById("inst_address").setAttribute("required","");
        document.getElementById("course_start").setAttribute("required","");
        document.getElementById("tution_fees").setAttribute("required","");
        document.getElementById("course_type_id").setAttribute("required","");
        document.getElementById("course_name_id").setAttribute("required","");
        document.getElementById("student_course_name_id").setAttribute("required","");
        document.getElementById("diploma_passed_yes").setAttribute("required","");
        
       
        $("#course_type_id")[0].selectedIndex = 0;
        $("#course_name_id")[0].selectedIndex = 0;
        $("#student_course_name_id")[0].selectedIndex = 0;


    }
    $("#diploma_passed_yes").on("change",diploma_passed_yes);
    $("#diploma_passed_no").on("change",diploma_passed_no);
    function diploma_passed_yes()
    {
        

        
        document.getElementById("current_inst_name").removeAttribute("required");
        document.getElementById("inst_address").removeAttribute("required");
        document.getElementById("course_start").removeAttribute("required");
        document.getElementById("tution_fees").removeAttribute("required");
        $('#current_inst_name').hide();
        $('#inst_address').hide();
        $('#course_start').hide();
        $('#tution_fees').hide();
        $('#current_inst_name_label').hide();
        $('#inst_address_label').hide();
        $('#course_start_label').hide();
        $('#tution_fees_label').hide();
        $('#fees_label').hide();
        
        
        $('#class10_passed_yes').hide();
        $('#class10_passed_no').hide();
        $('#class10_passed_que').hide();
        $('#class10_no_label').hide();
        $('#class10_yes_label').hide();
        $('#class10_passed_label_no').hide();
        $('#class10_passed_label_yes').hide();

        $('#class12_passed_yes').hide();
        $('#class12_passed_no').hide();
        $('#class12_passed_que').hide();
        $('#class12_no_label').hide();
        $('#class12_yes_label').hide();
        
        $("#course_type_id option[value=4]").attr('selected','selected');
          

       

        $("#course_type_id option[value=4]").attr('selected','selected');

          $.ajax({
                url: "{{ route('setcourse') }}?course_name_id="+541,
                method: 'GET',
                success: function(data) {
                    $('#course_name_id').html(data.html);
                    
                    
                }
            });

        $.ajax({
                url: "{{ route('setstudentcourse') }}?student_course_name_id="+137,
                method: 'GET',
                success: function(data) {
                    $('#student_course_name_id').html(data.html);
                    
                    
                }
            });
              
        
       
        
        
        
    }
     function diploma_passed_no()
    {
        
        
        $('#current_inst_name').show();
        $('#inst_address').show();
        $('#course_start').show();
        $('#tution_fees').show();
        $('#current_inst_name_label').show();
        $('#inst_address_label').show();
        $('#course_start_label').show();
        $('#tution_fees_label').show();
        $('#fees_label').show();
        $('#class12_passed_yes').show();
        $('#class12_passed_no').show();
        $('#class12_passed_que').show();
        $('#class12_no_label').show();
        $('#class12_yes_label').show();

        $('#class10_passed_label_no').show();
        $('#class10_passed_label_yes').show();
        $('#class10_passed_yes').show();
        $('#class10_passed_no').show();
        $('#class10_passed_que').show();
        $('#class10_no_label').show();
        $('#class10_yes_label').show();
        document.getElementById("current_inst_name").setAttribute("required","");
        document.getElementById("inst_address").setAttribute("required","");
        document.getElementById("course_start").setAttribute("required","");
        document.getElementById("tution_fees").setAttribute("required","");
        document.getElementById("course_type_id").setAttribute("required","");
        document.getElementById("course_name_id").setAttribute("required","");
        document.getElementById("student_course_name_id").setAttribute("required","");

         
         
       
        $("#course_type_id")[0].selectedIndex = 0;
        $("#course_name_id")[0].selectedIndex = 0;
        $("#student_course_name_id")[0].selectedIndex = 0;
    }
 </script>
<script type="text/javascript">
     $("#course_type_id").change(function(){
            $.ajax({
                url: "{{ route('getcourse') }}?course_type_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#course_name_id').html(data.html);
                }
            });
        });

    $("#marks").on("change",scoring);
    $("#cgpa").on("change",cgpa);
    function scoring()
    {
        
        $('#previous_marks_obtained').show();
        $('#previous_marks_total').show();
        $('#previous_obtained').show();
        $('#previous_total_obtained').show();
        $('#cgpa_previous_marks_obtained').hide();
        $('#cgpa_previous_marks_total').hide();
        $('#cgpa_obtained').hide();
        $('#cgpa_total').hide();


        
    }
    function cgpa()
    {
        
        $('#previous_marks_obtained').hide();
        $('#previous_marks_total').hide();
        $('#previous_obtained').hide();
        $('#previous_total_obtained').hide();
        $('#cgpa_previous_marks_obtained').show();
        $('#cgpa_previous_marks_total').show();
        $('#cgpa_obtained').show();
        $('#cgpa_total').show();

        
        
    }

    $("#previous_marks_obtained").on("keyup",previous_percentage);
    $("#previous_marks_total").on("keyup",previous_percentage);
    function previous_percentage(){
        
        
                var obtained= document.getElementById('previous_marks_obtained').value;
                var total=document.getElementById('previous_marks_total').value;
                var result=(parseFloat(obtained) / parseFloat(total))*100;
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('previous_percentage').value = result;
                                     }
        
        
        
        
    }
    $("#cgpa_previous_marks_obtained").on("keyup",cgpa_previous_percentage);
    function cgpa_previous_percentage()
    {
        var obtained= document.getElementById('cgpa_previous_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('previous_percentage').value = result;
                                     }   
    }
</script>
<script type="text/javascript">
  $("#ssc_marks").on("change",ssc_scoring);
    $("#ssc_cgpa").on("change",ssc_cgpa);
    function ssc_scoring()
    {
        
        $('#school_marks_obtained').show();
       
        
        $('#school_marks_total').show();
        $('#school_obtained').show();
        $('#school_total').show();
        $('#school_cgpa_obtained').hide();
        $('#cgpa_school_marks_obtained  ').hide();
        $('#school_cgpa_total').hide();
        $('#cgpa_school_marks_total').hide();
        $('#cgpa_school_marks_total').val('');
        $('#cgpa_school_marks_obtained  ').val('');
        
         $('#school_percentage').val('');

        
    }
    function ssc_cgpa()
    {
        
        
        $('#cgpa_school_marks_total').show();
        $('#school_cgpa_obtained').show();
        $('#cgpa_school_marks_obtained ').show();
        $('#school_cgpa_total').show();
        
        $('#school_marks_obtained').hide();
        $('#school_marks_total').hide();
        $('#school_obtained').hide();
        $('#school_total').hide();

        $('#school_marks_obtained').val('');
        $('#school_marks_total').val('');
        $('#school_percentage').val('');
        
        
        
    }
$("#school_marks_obtained").on("keyup",ssc_percentage);
$("#school_marks_total").on("keyup",ssc_percentage);
function ssc_percentage(){
        var obtained= document.getElementById('school_marks_obtained').value;
        var total=document.getElementById('school_marks_total').value;
        var result=(parseFloat(obtained) / parseFloat(total))*100;
        var result= result.toFixed(2);
        if (!isNaN(result)) {
                document.getElementById('ssc_percentage').value = result;
            }
    }
$("#cgpa_school_marks_obtained").on("keyup",cgpa_school_percentage);
    function cgpa_school_percentage()
    {
        var obtained= document.getElementById('cgpa_school_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('ssc_percentage').value = result;
                                     }   
    }

    $("#hsc_marks").on("change",hsc_scoring);
    $("#hsc_cgpa").on("change",hsc_cgpa);
    function hsc_scoring()
    {
        
        $('#hsc_obtained').show();
        $('#class_12_marks_obtained').show();
        $('#hsc_total').show();
        $('#class_12_out_of_total_marks').show();
        $('#hsc_cgpa_obtained').hide();
        $('#cgpa_class_12_marks_obtained  ').hide();
        $('#hsc_cgpa_total').hide();
        $('#cgpa_class_12_marks_total').hide();
        
        $('#cgpa_class_12_marks_obtained  ').val('');
        $('#cgpa_class_12_marks_total').val('');
        $('#class_12_marks_obtained_label').show();
        $('#class_12_out_of_total_marks_label').show();


        $('#hsc_cgpa_total_label').hide();
        
        

        
    }
    function hsc_cgpa()
    {
        
        
        $('#hsc_cgpa_obtained').show();
        $('#cgpa_class_12_marks_obtained  ').show();
        $('#hsc_cgpa_total').show();
        $('#cgpa_class_12_marks_total').show();
        $('#hsc_obtained').hide();
        $('#class_12_marks_obtained').hide();
        $('#hsc_total').hide();
        $('#class_12_out_of_total_marks').hide();
        $('#class_12_marks_obtained').val('');
        $('#class_12_out_of_total_marks').val('');
        
        $('#hsc_cgpa_total_label').show();
         $('#class_12_marks_obtained_label').hide();
        $('#class_12_out_of_total_marks_label').hide();
        
        
       
    }
    

    $("#cgpa_class_12_marks_obtained").on("keyup",cgpa_hsc_percentage);
    function cgpa_hsc_percentage()
    {
        var obtained= document.getElementById('cgpa_class_12_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('hsc_percentage').value = result;
                                     }   
    }
    $("#class_12_marks_obtained").on("keyup",hsc_percentage);
    $("#class_12_out_of_total_marks").on("keyup",hsc_percentage);
function hsc_percentage(){
        var obtained= document.getElementById('class_12_marks_obtained').value;
        var total=document.getElementById('class_12_out_of_total_marks').value;
        var result=(parseFloat(obtained) / parseFloat(total))*100;
        var result= result.toFixed(2);
        if (!isNaN(result)) {
                document.getElementById('hsc_percentage').value = result;
            }
    }  

$("#class12_appeared_yes").on("click",class12_appeared_yes);
function class12_appeared_yes(){
    var obtained=document.getElementById('class12_appeared_yes').value;
    

    
     $('#diploma_clg_name_label').hide();

     $('#diploma_clg_name').hide();
     document.getElementById("diploma_clg_name").removeAttribute("required");
     $('#diploma_state_label').hide();
     $('#diploma_state').hide();
     document.getElementById("diploma_state").removeAttribute("required");
     $('#diploma_passing_year_label').hide();
     $('#diploma_passing_year').hide();
     document.getElementById("diploma_passing_year").removeAttribute("required");
     $('#diploma_scoring').hide();
     $('#diploma_marks').hide();
     $('#diploma_cgpa').hide();
     $('#diploma_obtained').hide();

     $('#diploma_total_marks_obtained').hide();
     $('#diploma_total').hide();
     $('#diploma_out_of_total_marks').hide();
     $('#diploma_cgpa_obtained').hide();
     $('#diploma_cgpa_total').hide();
     $('#cgpa_diploma_marks_total').hide();
     $('#diploma_percentage_label').hide();
     document.getElementById("diploma_percentage").removeAttribute("required");
     $('#diploma_percentage').hide();
     $('#diploma_submit').hide();
     $('#diploma_marks_label').hide();
     $('#diploma_cgpa_label').hide();




    $('#class_12_clg_name').show();
    document.getElementById("class_12_clg_name").setAttribute("required","");
    $('#class_12_state').show();
    document.getElementById("class_12_state").setAttribute("required","");
    $('#class_12_clg_name_label').show();
    $('#class_12_state_label').show();
    $('#class_12_passing_yeat_label').show();
    $('#class_12_passing_yeat').show();
    document.getElementById("class_12_passing_yeat").setAttribute("required","");
    $('#hsc_marks').show();
    $('#hsc_cgpa').show();
    document.getElementById("hsc_marks").setAttribute("required","");
    
    $('#hsc_percentage_label').show();
    
    $('#hsc_percentage').show();
    document.getElementById("hsc_percentage").setAttribute("required","");
    $('#scoring_system').show();
    $('#hsc_marks_label').show();
    $('#hsc_cgpa_label').show();
    $('#hsc_save_details').show();

    

  
    
}
$("#class12_appeared_no").on("click",class12_appeared_no);
function class12_appeared_no(){
    var obtained=document.getElementById('class12_appeared_no').value;
    

    $('#diploma_submit').show();
    $('#class_12_clg_name').hide();
    document.getElementById("class_12_clg_name").removeAttribute("required");
    $('#class_12_state').hide();
    document.getElementById("class_12_state").removeAttribute("required");
    $('#class_12_clg_name_label').hide();

    $('#class_12_state_label').hide();

    $('#class_12_passing_yeat_label').hide();
    $('#class_12_passing_yeat').hide();
    document.getElementById("class_12_passing_yeat").removeAttribute("required");
    $('#hsc_marks').hide();
    document.getElementById("hsc_marks").removeAttribute("required");
    $('#hsc_cgpa').hide();
    document.getElementById("hsc_cgpa").removeAttribute("required");
    $('#class_12_marks_obtained_label').hide();
    $('#class_12_marks_obtained').hide();
    document.getElementById("class_12_marks_obtained").removeAttribute("required");
    $('#class_12_out_of_total_marks').hide();
    document.getElementById("class_12_out_of_total_marks").removeAttribute("required");
    $('#class_12_out_of_total_marks_label').hide();
    $('#hsc_cgpa_obtained_label').hide();
    document.getElementById("cgpa_class_12_marks_obtained").removeAttribute("required");
    $('#cgpa_class_12_marks_obtained').hide();
    $('#hsc_cgpa_total_label').hide();
    document.getElementById("cgpa_class_12_marks_total").removeAttribute("required");
    $('#cgpa_class_12_marks_total').hide();
    document.getElementById("hsc_percentage").removeAttribute("required");
    $('#hsc_percentage_label').hide();
    $('#hsc_percentage').hide();
    
    $('#scoring_system').hide();
    $('#hsc_marks_label').hide();
    $('#hsc_cgpa_label').hide();
    $('#hsc_save_details').hide();

     $('#diploma_clg_name_label').show();
     $('#diploma_clg_name').show();
     document.getElementById("diploma_clg_name").setAttribute("required","");
     $('#diploma_state_label').show();
     $('#diploma_state').show();
     document.getElementById("diploma_state").setAttribute("required","");
     $('#diploma_passing_year_label').show();
     $('#diploma_passing_year').show();
     document.getElementById("diploma_passing_year").setAttribute("required","");
     $('#diploma_scoring').show();
     $('#diploma_marks').show();
     $('#diploma_cgpa').show();
    
     
     
     $('#diploma_percentage_label').show();

     $('#diploma_percentage').show();
     document.getElementById("diploma_marks").setAttribute("required","");
     document.getElementById("diploma_percentage").setAttribute("required","");
     $('#diploma_submit').show();
     $('#diploma_marks_label').show();
     $('#diploma_cgpa_label').show();

     
    
    
}
$("#diploma_marks").on("change",diploma_scoring);
    $("#diploma_cgpa").on("change",diploma_cgpa);
    function diploma_scoring()
    {
        
        $('#diploma_obtained').show();
        $('#diploma_total').show();
        $('#diploma_total_marks_obtained').show();
        $('#diploma_out_of_total_marks').show();
        $('#diploma_cgpa_obtained').hide();
        $('#diploma_cgpa_total').hide();
        $('#cgpa_diploma_marks_obtained ').hide();
        $('#cgpa_diploma_marks_total ').hide();
        $('#cgpa_diploma_marks_obtained ').val('');
        $('#cgpa_diploma_marks_total ').val('');
        $('#diploma_percentage').val('');
        
        
        
        

        
    }
    function diploma_cgpa()
    {
        
        
        $('#diploma_cgpa_obtained').show();
        $('#diploma_cgpa_total').show();
        $('#cgpa_diploma_marks_obtained ').show();
        $('#cgpa_diploma_marks_total ').show();
        
        $('#diploma_obtained').hide();
        $('#diploma_total').hide();
        $('#diploma_total_marks_obtained').hide();
        $('#diploma_out_of_total_marks').hide();
        $('#diploma_total_marks_obtained').val('');
        $('#diploma_out_of_total_marks').val('');
        $('#diploma_percentage').val('');
        
        
       
    }
    

    $("#cgpa_diploma_marks_obtained").on("keyup",cgpa_diploma_percentage);
    function cgpa_diploma_percentage()
    {
        var obtained= document.getElementById('cgpa_diploma_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('diploma_percentage').value = result;
                                     }   
    }
    $("#diploma_total_marks_obtained").on("keyup",diploma_percentage);
    $("#diploma_out_of_total_marks").on("keyup",diploma_percentage);
    function diploma_percentage(){
        var obtained= document.getElementById('diploma_total_marks_obtained').value;
        var total=document.getElementById('diploma_out_of_total_marks').value;
        var result=(parseFloat(obtained) / parseFloat(total))*100;
        var result= result.toFixed(2);
        if (!isNaN(result)) {
                document.getElementById('diploma_percentage').value = result;
            }
    }    

$("#class12_appeared_both").on("click",class12_appeared_both);
function class12_appeared_both(){
    

    $('#class_12_clg_name').show();
    $('#class_12_state').show();
    $('#class_12_clg_name_label').show();
    $('#class_12_state_label').show();
    $('#class_12_passing_yeat_label').show();
    $('#class_12_passing_yeat').show();
    $('#hsc_marks').show();
    $('#hsc_cgpa').show();
    
    $('#hsc_percentage_label').show();
    $('#hsc_percentage').show();
    $('#scoring_system').show();
    $('#hsc_marks_label').show();
    $('#hsc_cgpa_label').show();
   

    $('#diploma_clg_name_label').show();
     $('#diploma_clg_name').show();
     
     $('#diploma_state_label').show();
     $('#diploma_state').show();
    
     $('#diploma_passing_year_label').show();
     $('#diploma_passing_year').show();
    
     $('#diploma_scoring').show();
     $('#diploma_marks').show();
     $('#diploma_cgpa').show();
     
     $('#diploma_percentage_label').show();

     $('#diploma_percentage').show();
    
     $('#diploma_submit').show();
     $('#diploma_marks_label').show();
     $('#diploma_cgpa_label').show();

}
$("#grad_marks").on("change",grad_scoring);
    $("#grad_cgpa").on("change",grad_cgpa);
    function grad_scoring()
    {
        
        $('#grad_obtained').show();
        $('#grad_total').show();
        $('#grad_total_marks').show();
       
        $('#grad_out_of_total_marks').show();
       
        $('#grad_cgpa_obtained').hide();
        $('#grad_cgpa_total').hide();
        $('#cgpa_grad_marks_obtained').hide();
        $('#cgpa_grad_marks_total').hide();
        $('#cgpa_grad_marks_obtained').val('');
        $('#cgpa_grad_marks_total').val('');
        $('#grad_percentage').val('');

        document.getElementById('grad_total_marks').setAttribute("required","");
        document.getElementById('grad_out_of_total_marks').setAttribute("required","");
       
    
    }
    function grad_cgpa()
    {
        
        
        $('#grad_cgpa_obtained').show();
        $('#grad_cgpa_total').show();
        $('#cgpa_grad_marks_obtained').show();
        $('#cgpa_grad_marks_total').show();
        
        $('#grad_obtained').hide();
        $('#grad_total').hide();
        $('#grad_total_marks').hide();
        $('#grad_out_of_total_marks').hide();
        $('#grad_total_marks').val('');
        $('#grad_out_of_total_marks').val('');
        $('#grad_percentage').val('');

        document.getElementById('cgpa_grad_marks_obtained').setAttribute("required","");
        document.getElementById('cgpa_grad_marks_total').setAttribute("required","");
        
        
    }
    

    $("#cgpa_grad_marks_obtained").on("keyup",cgpa_grad_percentage);
    function cgpa_grad_percentage()
    {
        var obtained= document.getElementById('cgpa_grad_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('grad_percentage').value = result;
                                     }   
    }
$("#grad_total_marks").on("keyup",grad_percentage);
$("#grad_out_of_total_marks").on("keyup",grad_percentage);

function grad_percentage(){
        var obtained= document.getElementById('grad_total_marks').value;
        
        var total=document.getElementById('grad_out_of_total_marks').value;
         
        var result=(parseFloat(obtained) / parseFloat(total))*100;

        var result= result.toFixed(2);
        if (!isNaN(result)) {
                document.getElementById('grad_percentage').value = result;
                
            }
    } 
  $("#marks").on("change",scoring);
    $("#cgpa").on("change",cgpa);
    function scoring()
    {
        
        $('#previous_marks_obtained').show();
        $('#previous_marks_total').show();
        $('#previous_obtained').show();
        $('#previous_total_obtained').show();
        $('#cgpa_previous_marks_obtained').hide();
        $('#cgpa_previous_marks_total').hide();
        $('#cgpa_obtained').hide();
        $('#cgpa_total').hide();
        $('#cgpa_previous_marks_obtained').val('');
        $('#cgpa_previous_marks_total').val('');
        //previous_percentage
        $('#previous_percentage').show();
       
        $('#prev_submit').show();

        
    }
    function cgpa()
    {
        
        $('#previous_marks_obtained').hide();
        $('#previous_marks_total').hide();
        $('#previous_obtained').hide();
        $('#previous_total_obtained').hide();
        $('#cgpa_previous_marks_obtained').show();
        $('#cgpa_previous_marks_total').show();
        $('#cgpa_obtained').show();
        $('#cgpa_total').show();
        $('#previous_marks_obtained').val('');
        $('#previous_marks_total').val('');
        $('#previous_percentage').show();
       
        $('#prev_submit').show();
        
        
    }

    $("#previous_marks_obtained").on("keyup",previous_percentage);
    $("#previous_marks_total").on("keyup",previous_percentage);
    function previous_percentage(){
        
        
                var obtained= document.getElementById('previous_marks_obtained').value;
                var total=document.getElementById('previous_marks_total').value;
                var result=(parseFloat(obtained) / parseFloat(total))*100;
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('previous_percentage').value = result;
                                     }
        
        
        
        
    }
    $("#cgpa_previous_marks_obtained").on("keyup",cgpa_previous_percentage);
    function cgpa_previous_percentage()
    {
        var obtained= document.getElementById('cgpa_previous_marks_obtained').value;
        var result=(parseFloat(obtained) * 9.5);
                var result= result.toFixed(2);
                if (!isNaN(result)) {
                    document.getElementById('previous_percentage').value = result;
                                     }   
    }  
</script>
<script type="text/javascript">
    $(document).ready(function() {
  // Your code here
  fun_showdetails();
});
</script>
<script type="text/javascript">
        function fun_showdetails()
{
  var select_status=$("#course_type_id").val();
  
  if (select_status=='2') {
    $('#current_year').hide();
    $('#class10_details').show();
    $('#class12_details').hide();
    $('#diploma_details').hide();
    $('#graduation_details').hide();
    

    
    

  }
  else if (select_status=='3') {
    $('#class10_details').show();
    $('#class12_details').show();
    $('#diploma_details').hide();
    $('#graduation_details').hide();
    $('#current_year').show();

    
   
    

  }
  else if (select_status=='4') {
     $('#class10_details').show();
     $('#class12_details').show();
     $('#diploma_details').show();
     $('#graduation_details').hide();
     $('#current_year').show();

    
    

  }
  else if (select_status=='5') {
    $('#class10_details').show();
    $('#class12_details').show();
    $('#diploma_details').show();
    $('#graduation_details').show();
    $('#current_year').show();

     $('#grad_doc').show();
  }
  else if (select_status=='6') {
    $('#class10_details').show();
    $('#class12_details').show();
    $('#diploma_details').hide();
    $('#graduation_details').hide();
    $('#current_year').show();

    
  }
  else if (select_status=='7') {
    $('#class10_details').show();
    $('#class12_details').show();
    $('#diploma_details').hide();
    $('#graduation_details').hide();
    $('#current_year').show();

    
  }
  else if (select_status=='8') {
    $('#class10_details').show();
    $('#class12_details').show();
    $('#diploma_details').hide();
    $('#graduation_details').hide();
    $('#current_year').hide();

    
  }
  else 
  {
    $('#current_year').hide();
    $('#class10_details').hide();
    $('#class12_details').hide();
    $('#diploma_details').hide();
    $('#graduation_details').hide();


  }
}

$("#course_type_id").on("change",fun_showdetails);

</script>


<script type="text/javascript">
    function setadd()
    {
        if($("#address").is(":checked")){
            
            $('#permanent_add').val($('#current_add').val());
            $('#permanent_state').val($('#current_state').val());
            $('#permanent_city').val($('#current_city').val());
            $('#permanent_pincode').val($('#pincode').val());

            
        }
        else{
            $('#permanent_add').val('');
            $('#permanent_state').val('');
            $('#permanent_city').val('');
            $('#permanent_pincode').val('');
        }
    }

    $('#address').click(function(){
        setadd();
    })
</script>

@endsection

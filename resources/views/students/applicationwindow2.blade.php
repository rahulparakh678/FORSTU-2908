@extends('layouts.student')
@section('content')

<h1> Document Section
</h1>

<table class="table table-striped">
                    
    <thead class="thead-dark">
    <th>Document Name</th>
    <th>Document Link</th>
    <th>Action</th>
    </thead>
    <tbody>
    	@foreach ($documents as $document)
    

    	<tr>
    		<td> 
    			{{$document}}
    		</td>
    		<td></td>
    		<td>
    			@switch ($document) 
                                    
                                    @case ('Photo')
                                    	{{--
                                        <a href="{{$profile->photo ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>--}}
                                        @if($profile->photo===null)
                    <td>
                
                        <form action="{{route('photoupload')}} " method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
    
    
                        <input type="file" name="photo" required>
                        <button class="btn btn-success" type="submit" value="Upload">Upload </button>
                
                        </form>     
                
                    </td>
                        @else
                    <td>

                        @if(!empty($profiles->photo))
                        <a href="{{$profiles->photo}} " style="text-decoration: none;" target="_blank" class="btn btn-primary">View &nbsp;<i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
                        @endif 
                        
                        <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#photo">Delete &nbsp;<i class="fa fa-trash-o fa-lg" aria-hidden="true"></i> </button>

                        <div class="modal fade" id="photo" role="dialog">
                            <div class="modal-dialog">
    
                        <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2>Photo Deleted Successfully</h2>
          
                                </div>
                            <div class="modal-body">
                                <p>Your Image is Deleted successfully. Now Reupload the Photo here</p>
                                <form action="{{route('photoupload')}} " method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
    
    
                                <input type="file" name="photo" required>
                                <button class="btn btn-success" type="submit" value="Upload">Upload </button>
                
                                </form>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        </div>
      
                    </div>
                 </div>
                    </td>
                        @endif
            
                                        @break;
                                    @case ('Aadhar card')
                                        <a href="{{$profile->aadhar_card ?? ''}}" style="text-decoration: none; " target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                    @case ('Parents Aadhar Card')
                                        <a href="{{$profile->paadhar ?? ''}}" style="text-decoration: none; " target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                        
                                    @case ('Address Proof')
                                        <a href="{{$profile->address_proof ?? ''}}" style="text-decoration: none; " target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                    @case ('Caste Certificate')
                                        <a href="{{$profile->caste_certificate ?? ''}}" style="text-decoration: none; " target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                    @case ('Domicile Certificate')
                                        
                                        <a href="{{$profile->caste_certificate ?? ''}}" style="text-decoration: none; " target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Income Certificate')
                                        <a href="{{$profile->income_certificate ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Bank Passbook')
                                        <a href="{{$profile->bank_passbook ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Fee Structure')
                                        {{$profile->aadhar_card ?? ''}}
                                        @break;
                                    @case ('College/School ID Card')
                                        
                                        <a href="{{$profile->clg_id_card ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Bonafide Certificate')
                                        <a href="{{$profile->bonafide_certificate ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Admission Letter/ Allotment Letter')
                                        <a href="{{$profile->admission_letter ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Current Year Fees Reciept')
                                        
                                        <a href="{{$profile->currentyear_fees_reciept ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Hostel Fees Reciept')
                                        <a href="{{$profile->hostel_reciept ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Class 10 Marksheet')
                                        
                                        <a href="{{$profile->class10_marksheet ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Previous Year/Previous Semester Marksheet')
                                        <a href="{{$profile->previous_marksheet ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                    @case ('Recommendation Letter')
                                        <a href="{{$profile->pan_card ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Ration Card')
                                        <a href="{{$profile->ration_card ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @case ('Class 12 Marksheet')
                                        <a href="{{$profile->class12_marksheet ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                             
                                           
                                            
                                    @case ('Diploma Marksheet')
                                        <a href="{{$profile->diploma_marksheet ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        
                                        @break;
                                    @case ('Graduation Marksheet')
                                    
                                        <a href="{{$profile->graduation_marksheet ?? ''}}" style="text-decoration: none;" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        @break;
                                    @default
                                        // Handle the case if the document name //doesn't match any specific condition
                                        @break;
                                @endswitch
    		 </td>
    	</tr>
    	@endforeach
    </tbody>
</tbody>
@endsection

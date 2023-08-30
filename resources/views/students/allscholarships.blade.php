@extends('layouts.student')
@section('content')





<div class="container">
  <div class="row ">
  	@foreach($scholarships as $scholarship)

  	<div class="col-md-4">
  		<div class="card border-primary">

        		<img class="card-img-top" src="{{ asset('avatar\main2.png')}}" alt="Card image cap" style="width: 50%; align-self: center;">
      	  	<div class="card-body">
          		<div class="card-title"><strong><center>{{
            	$scholarship->scheme_name}}</center></strong>
          		</div>
          		<hr>
          
            	<i class="fas fa-trophy" aria-hidden="true"></i>&nbsp;
            	<strong>Scholarship Amount : </strong>
            	{{$scholarship->scholarship_amount}}
          
            	<hr>
          
            	<a href="{{ route('showdetails',$scholarship->id)}}">
              	<center><button class="btn btn-primary ">View Details</button></center></a>
              	<br>
           </div>
      	</div>
    </div>

    
	@endforeach

   </div>
{{ $scholarships->links() }}
 </div>
 





@endsection

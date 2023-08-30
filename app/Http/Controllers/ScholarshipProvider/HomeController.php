<?php

namespace App\Http\Controllers\ScholarshipProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipShortlisted;
use App\Scholarship;
use App\StudentProfile;
use App\Mail\ScholarshipSelection;
use App\Mail\Funddisbursed;
use App\Verification;
class HomeController extends Controller
{
    //
    public function index()
    {
         //$listschemes = Scholarship::where('user_id',auth()->user()->id)->get();
        //return view('scholarshipprovider.home',compact('listschemes'));
        //$listschemes = Scholarship::where('user_id', auth()->user()->id)->get();
        $listschemes = Scholarship::where('user_id', auth()->user()->id)
                                  ->select('id', 'scheme_name')
                                  ->get();
        if ($listschemes->isEmpty()) {
            // No scholarships found, redirect to the same view
            //return redirect()->route('providers.home')
                          // ->with('info', 'You don\'t have any scholarships listed yet.');
                           return view('scholarshipprovider.home', compact('listschemes'))->with('info', 'You don\'t have any scholarships listed yet.');
        }
        else{
            return view('scholarshipprovider.home', compact('listschemes'));
        }

        
    }
    // app/Http/Controllers/ScholarshipProvider/HomeController.php
/*public function getApplicationData($schemeId, $applicationType)
{
    // Logic to fetch application count data based on the selected scheme_id and application type
    $applications = DB::table('scholarship_user')
        ->where('scholarship_id', $schemeId)
        ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw('COUNT(*) as count'))
        ->groupBy('date')
        ->get();

    // Prepare data for the chart
    $labels = $applications->pluck('date')->toArray();
    $values = $applications->pluck('count')->toArray();

    // Return the data as JSON
    return response()->json([
        'labels' => $labels,
        'values' => $values,
    ]);
}
*/
public function getApplicationList($schemeId)
    {
        // Logic to fetch the list of applications based on the selected scheme_id
        $applications = DB::table('scholarship_user')
            ->where('scholarship_id', $schemeId)
            ->get();

        // Return the data as JSON
        return response()->json($applications);
    }



    public function verificationstore(Request $request){
         //return redirect->back();
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            's_id' => 'required|integer',
            'verification_type' => 'required|string',
            'status' => 'required|string',
            'remark' => 'nullable|string',
            'reference_link' => 'nullable|string',
        ]);

        // Check if a duplicate entry exists
        $duplicateEntry = Verification::where('user_id', $request->user_id)
            ->where('verification_type', $request->verification_type)
            ->first();

        if ($duplicateEntry) {
            return redirect()->back()->with('error', 'Duplicate entry for verification type');
        }
        else{
            // Create a new verification detail
                $verificationDetail = new Verification;
                $verificationDetail->fill($validatedData);
                $verificationDetail->save();

                return redirect()->back()->with('success', 'Verification details stored successfully.');
        }

        
    }
    public function verificationupdate(Request $request, $id){
        $verification = Verification::findOrFail($id);
    
    // Update the verification details
        $verification->verification_type = $request->input('verification_type');
        $verification->status = $request->input('status');
        $verification->remark = $request->input('remark');
        $verification->reference_link = $request->input('reference_link');
        $verification->save();

        return redirect()->back()->with('success', 'Verification details updated successfully.');
    }
    public function verificationdelete($id)
    {
        $verification = Verification::findOrFail($id);
    
    // Delete the verification entry
        $verification->delete();

        return redirect()->back()->with('success', 'Verification deleted successfully.');
    }
    

    public function Shortlised(Request $request, $id)
    {
    	
    	//$scholarships=DB::table('scholarship_user')->where('id','23')->update(['status'=>'Shortlised']);
    	$scholarships=DB::table('scholarship_user')->where('id',$id)->update(['status'=>'Shortlised']);
        $scholarship=DB::table('scholarship_user')->where('id',$id)->first();
        $scholar=Scholarship::findOrFail($scholarship->scholarship_id);
        $profile=StudentProfile::select('email','fullname')->where('user_id',$scholarship->user_id)->first();
        
       
        $details=[
        'schemename'=>$scholar->scheme_name,
        'fullname'=>$profile->fullname,
        
        
    ];
        Mail::to($profile->email)->send(new ScholarshipShortlisted($details));

    	return redirect()->back()->with('message','Scholarship Status Successfully Updated');
    }

     public function Rejected(Request $request, $id)
    {
    	
    	//$scholarships=DB::table('scholarship_user')->where('id','23')->update(['status'=>'Shortlised']);
    	$scholarships=DB::table('scholarship_user')->where('id',$id)->update(['status'=>'Rejected']);

    	return redirect()->back()->with('message','Scholarship Status Successfully Updated');
    }

     public function Awarded(Request $request, $id)
    {
    	
    	//$scholarships=DB::table('scholarship_user')->where('id','23')->update(['status'=>'Shortlised']);
    	$scholarships=DB::table('scholarship_user')->where('id',$id)->update(['status'=>'Awarded']);
        $scholarship=DB::table('scholarship_user')->where('id',$id)->first();
        $scholar=Scholarship::findOrFail($scholarship->scholarship_id);
        $profile=StudentProfile::select('email','fullname')->where('user_id',$scholarship->user_id)->first();
        
       
        $details=[
        'schemename'=>$scholar->scheme_name,
        'fullname'=>$profile->fullname,
        
        
        ];
        Mail::to($profile->email)->send(new ScholarshipSelection($details));
    	return redirect()->back()->with('message','Scholarship Status Successfully Updated');
    }

    public function funddisbursed(Request $request, $id)
    {
        $scholarships=DB::table('scholarship_user')->where('id',$id)->update(['status'=>'Fund Disbursed']);
        $scholarship=DB::table('scholarship_user')->where('id',$id)->first();
        $scholar=Scholarship::findOrFail($scholarship->scholarship_id);
        $profile=StudentProfile::select('email','fullname')->where('user_id',$scholarship->user_id)->first();
        
       
        $details=[
        'schemename'=>$scholar->scheme_name,
        'fullname'=>$profile->fullname,
        
        
        ];
        Mail::to($profile->email)->send(new Funddisbursed($details));
        return redirect()->back()->with('message','Scholarship Status Successfully Updated');
    }
    
    
}

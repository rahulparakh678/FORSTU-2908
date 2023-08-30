<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Scholarship;
use Auth;
use App\StudentProfile;
use App\StudStatus;
use DB;
use App\StudentCourses;
use App\Coursetype;
use App\Mail\StudentRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipApplicationSubmitted;
use App\User;
use App\Documents;
use App\Caste;
use App\Course;
class HomeController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth','verified']);

    }


    
    public function studentsview(Request $request){

        $user_id=Auth::user()->id;
        
        //$profile=StudentProfile::where()
        $name=Auth::user()->name;
        $status=$request['STATUS'];
        $respcode=$request['RESPCODE'];
        $respmsg=$request['RESPMSG'];
        $txn_date=$request['TXNDATE'];
        $txn_paymentmode=$request['PAYMENTMODE'];

        DB::table('sfcpayments')->insertGetId([
                'user_id' => $user_id,
                'user_name'=>$name,
                'txn_status'=>$status,
                'txn_respmsg'=>$respmsg,
                'txn_date'=>$txn_date,
                'txn_paymentmode'=>$txn_paymentmode,
            ]);
         
        if ($respcode==01) {
            // code...
            return view('students.paymentsuccess',compact('status','respcode','respmsg'));
        }
        else{

         
            //return view('students.paymentfail',compact('status','respcode','respmsg','name'));
             return view('students.paymentfail',compact('status','respcode','respmsg','name','user_id','txn_date','txn_paymentmode'));
        }
    }

    public function index()
    {

        if(StudentProfile::where('user_id',auth()->user()->id)->exists())
        {
             $profile=StudentProfile::where('user_id',Auth::user()->id)->first();
             $studentcourse=StudentCourses::all();
             $course_types = Coursetype::all();
             return view('students.home',compact('profile','studentcourse','course_types'));
        }
        else
        {
            $studentcourse=StudentCourses::all();
            $course_types = Coursetype::all();
            return view('students.home' ,compact('studentcourse','course_types'));
        }
        
    }
    public function myscholarship()
    {   
         $user = auth()->user();
        $data = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ref_code' => $user->ref_code,
            'section' => 'Active Scholarship',
            'clicked_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::insert('INSERT INTO clicked_sections (user_id, user_name, ref_code, section, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :section, :clicked_at, :created_at, :updated_at)', $data);
        $profile = StudentProfile::select('student_course_name_id','gender','course_name_id')
            ->where('user_id', Auth::user()->id)
            ->first();

        //$profile=StudentProfile::where('user_id',Auth::user()->id)->first();
    	$scholarships=Scholarship::where('status','Active')->get();
    	return view('students.viewscholarships',compact('scholarships','profile'));
    }
    public function allscholarships()
    {
        $user = auth()->user();
        $ref_code = $user->ref_code ?? null;
    $data = [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'ref_code' => $user->ref_code,
        'section' => 'All Scholarships',
        'clicked_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ];

    DB::insert('INSERT INTO clicked_sections (user_id, user_name, ref_code, section, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :section, :clicked_at, :created_at, :updated_at)', $data);
        //$profile=StudentProfile::where('user_id',Auth::user()->id)->first();
        // $profile=StudentProfile::where('user_id', Auth::user()->id)
                         //  ->value('paid');
        $profile = StudentProfile::select('paid')
            ->where('user_id', Auth::user()->id)
            ->first();

        $scholarships=Scholarship::paginate(5);
        return view('students.allscholarships',compact('scholarships','profile'));
    }
    public function applynowsection($id)
    {
        $user = auth()->user();
        $ref_code = $user->ref_code ?? null;
        $scholarship=Scholarship::findOrFail($id);
        $schemename=$scholarship->scheme_name;

        $data = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ref_code' => $ref_code,
            'scholarship_name' => $schemename,
            'clicked_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::insert('INSERT INTO applynow_scholarship_activity(user_id, user_name, ref_code, scholarship_name, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :scholarship_name, :clicked_at, :created_at, :updated_at)', $data);
            return redirect()->to($scholarship->application_link);

    }
    public function applicationwindow(Request $request,$id)
    {
        $scholarship_id=Scholarship::findOrFail($id);
        $profile=StudentProfile::where('user_id',Auth::user()->id)->first();
        $castes=Caste::all()->pluck('caste_name');
        $studentcourse=StudentCourses::all()->pluck('course_name');
        $course_types = Coursetype::all();
        $course=Course::all()->pluck('course_name');
        if (isset($profile)) {
            // code...

            return view('students.applicationwindow',compact('profile','castes','studentcourse','course_types','course','scholarship_id'));
        }
        else{
            return view('students.applicationwindow',compact('scholarship_id'));
        }
        
    }
    public function applicationwindow2(Request $request,$id)
    {
        $scholarship_id=Scholarship::findOrFail($id);
       // $scholarship_id = DB::table('scholarships')->where('id', $id)->value('id');

        //$scholarship_id = Scholarship::findOrFail($id)->pluck('id')->first();
        //$scholarship_id = Scholarship::findOrFail($id)->value('id');
        //$scholarship_id = DB::table('scholarships')->select('id')->where('id', $id)->first();


        //$document_scholarship=DB::table('document_scholarship')->where('scholarship_id',$scholarship_id->id)->toArray();

       // $documents = DB::table('documents')
    //->whereIn('id', $document_scholarship)
    //->pluck('name')
    //->toArray();
        $document_scholarship = DB::table('document_scholarship')
    ->where('scholarship_id', $scholarship_id->id)
    ->pluck('documents_id')
    ->toArray();

$documents = DB::table('documents')
    ->whereIn('id', $document_scholarship)
    ->pluck('document_name')
    ->toArray();

    //$profile=StudentProfile::where('user_id',Auth::user()->id);
    $profile = StudentProfile::where('user_id', Auth::user()->id)->first();
    //return view('students.applicationwindow2', ['documents' => $documents]);
    return view('students.applicationwindow2', [
    'documents' => $documents,
    'profile' => $profile,
]);
    //return $documents;
//return view('your.blade.file', compact('documents'));

        //return $document_scholarship;
       // return view('students.applicationwindow2',['documents' => $documents]);
    

    }
    public function showdetails($id)
    {

    	$scholarships=Scholarship::find($id);

        $studentcourse=DB::table('course_scholarship')->where('scholarship_id',$id)->get();
        $document_student=DB::table('document_student')->where('user_id',Auth::user()->id)->pluck('documents_id');
        $requiredDocuments = DB::table('document_scholarship')->where('scholarship_id',$id)->pluck('documents_id');
        $missingdoc=$requiredDocuments->diff($document_student);
        $missingdoc->all();
        //$documents=Documents::all();
        $doc_names=DB::table('documents')->whereIn('id',$missingdoc)->pluck('document_name');
        $user = auth()->user();
        $ref_code = $user->ref_code ?? null;
        $data = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ref_code' => $ref_code,
            'scholarship_name' => $scholarships->scheme_name,
            'clicked_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::insert('INSERT INTO scholarship_clicked_sections (user_id, user_name, ref_code, scholarship_name, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :scholarship_name, :clicked_at, :created_at, :updated_at)', $data);
    	return view('students.scholarshipdetails',compact('scholarships','studentcourse','doc_names'));
    }
    
    public function checkDocuments(Request $request, $id)
    {
        //$scholarshipId = $id;
        //$userId = Auth::user()->id;
        //$scholarship=Scholarship::findOrFail($id);
        //$user = User::findOrFail($userId);
        
        //$studentprofile=StudentProfile::where('user_id',Auth::user()->id)->first();
        $document_student=DB::table('document_student')->where('user_id',Auth::user()->id)->pluck('documents_id');
        //$missingdoc=array_diff($requiredDocuments, $document_student);
        $requiredDocuments = DB::table('document_scholarship')->where('scholarship_id',$id)->pluck('documents_id');
        $missingdoc=$requiredDocuments->diff($document_student);
        $missingdoc->all();
        //$documents=Documents::all();
        $doc_names=DB::table('documents')->whereIn('id',$missingdoc)->pluck('document_name');
        
        if ($doc_names->isEmpty()) {
            return response()->json(['message' => 'All documents uploaded.']);

        }else {
        //return response()->json(['message' => 'Please upload the following documents:', 'doc_name' => $doc_names]);
            return back()->with('doc_names',$doc_names);
    }
    //return $doc_name;

    }
    public function apply(Request $request,$id)
    {
         $user = auth()->user();
        $ref_code = $user->ref_code ?? null;
        
       
       $status='Application Status Submitted Successfully';
        $schemeid=Scholarship::find($id);
        $schemeid->users()->attach(Auth::user()->id,['user_name'=>Auth::user()->name,'status' => 'Application Submitted']);
        
        //return redirect()->back()->with('message','Successfully Applied to Scholarship');
        $scholarships=Scholarship::all();
        $StudStatus=StudStatus::where('user_id',auth()->user()->id)->get();

        $profile=StudentProfile::select('email','fullname')->where('user_id',auth()->user()->id)->first();
        
       
        $details=[
        'schemename'=>$schemeid->scheme_name,
        'fullname'=>$profile->fullname,
        
        
    ];
     $schemename=$schemeid->scheme_name;

        $data = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ref_code' => $ref_code,
            'scholarship_name' => $schemename,
            'clicked_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::insert('INSERT INTO applynow_scholarship_activity(user_id, user_name, ref_code, scholarship_name, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :scholarship_name, :clicked_at, :created_at, :updated_at)', $data);
        Mail::to($profile->email)->send(new ScholarshipApplicationSubmitted($details));
       
        return view('students.appliedscholarship',compact('scholarships','StudStatus'))->with('message','Successfully Applied to Scholarship');
    }

    public function appliedscholarship()
    {
        $user = auth()->user();
    $data = [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'ref_code' => $user->ref_code,
        'section' => 'Applied Scholarships',
        'clicked_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),

    ];

    DB::insert('INSERT INTO clicked_sections (user_id, user_name, ref_code, section, clicked_at, created_at, updated_at) 
                VALUES (:user_id, :user_name, :ref_code, :section, :clicked_at, :created_at, :updated_at)', $data);
       // $scholarships=\DB::table('scholarship_user')->where('user_id',auth::user()->id)->get();
        //$scholarships=Scholarship::->users->where('id',auth()->user()->id)->get();
        //$scholarships=$scholarships->users->where('id',auth()->user()->id)->get();
        
        //$scholarships=Scholarship::has('users')->where('user_id',auth()->user()->id)->get();
        //$scholarships=Scholarship::where('user_id',auth()->user()->id)->get();
        //$scholarships=Scholarship::all();
        $scholarships=Scholarship::all();
        $StudStatus=StudStatus::where('user_id',auth()->user()->id)->get();
        $profile=StudentProfile::where('user_id',auth()->user()->id)->where('paid','YES')->first();
       // $scholarships=$scholarships->users()->where('id',auth()->user()->id)->get();
        //$scholarships=$scholarships->users->where('id',auth()->user()->id)->get();
        //$scholarships->users()->get();
        //$scholarships=$scholarships->users()->wherePivot('user_id',auth()->user()->id)->get();   
        
        return view('students.appliedscholarship',compact('scholarships','StudStatus','profile'));
    }
    

    
}

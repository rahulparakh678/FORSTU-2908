<?php

namespace App\Http\Controllers\ScholarshipProvider;

use App\Category;
use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySetupscholarshipRequest;
use App\Http\Requests\StoreSetupscholarshipRequest;
use App\Http\Requests\UpdateSetupscholarshipRequest;
use App\ScholarshipProvider;
use App\Setupscholarship;
use App\Scholarship;
use App\StudentProfile;
use DB;
use App\StudentCourses;
use App\Documents;
use App\Verification;
class SetupscholarshipController extends Controller
{
    //

    public function index()
    {
    	$setupscholarships = Scholarship::where('user_id',auth()->user()->id)->get();

        return view('scholarshipprovider.setupscholarships.index', compact('setupscholarships'));
    }
    public function setupscholarship()
    {
        $studentCourses=StudentCourses::all();
        $companies=ScholarshipProvider::all();
        return view('scholarshipprovider.setupscholarships.setupscholarship',compact('companies','studentCourses'));
    }

    public function listscheme()
    {

        $listschemes = Scholarship::where('user_id',auth()->user()->id)->get();
        return view('scholarshipprovider.applications.listschemes',compact('listschemes'));
    }
    
    public function create()
    {
    	$company_names = ScholarshipProvider::all()->pluck('organization_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

       
         $courses = StudentCourses::all()->pluck('course_name', 'id');
         $documents = Documents::all()->pluck('document_name', 'id');

        return view('scholarshipprovider.setupscholarships.create', compact('company_names', 'categories', 'courses','documents'));
    }
    public function store(StoreSetupscholarshipRequest $request)
    {
        $setupscholarship = Scholarship::create($request->all());
        $setupscholarship->courses()->sync($request->input('courses', []));
        $setupscholarship->documents()->sync($request->input('documents', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $setupscholarship->id]);
        }

        return redirect()->route('setup');
    }

    public function edit(Setupscholarship $setupscholarship,$id)
    {
        
    	$setupscholarship=Scholarship::find($id);
        $company_names = ScholarshipProvider::all()->pluck('organization_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

       
         $courses = StudentCourses::all()->pluck('course_name', 'id');
         $documents = Documents::all()->pluck('document_name', 'id');
        $setupscholarship->load('company_name', 'category', 'courses');

        return view('scholarshipprovider.setupscholarships.edit', compact('company_names', 'categories', 'courses', 'setupscholarship','documents'));
    }

    public function update(UpdateSetupscholarshipRequest $request, Setupscholarship $setupscholarship,$id)

    {
    	$setupscholarship=Scholarship::find($id);

        $setupscholarship->update($request->all());
        $setupscholarship->courses()->sync($request->input('courses', []));
        //$setupscholarship->documents()->sync($request->input('documents', []));
        return redirect()->route('setup');
    }

    public function show(Setupscholarship $scholarships,$id)
    {
        
    	$scholarships=Scholarship::find($id);
        $studentcourse=DB::table('course_scholarship')->where('scholarship_id',$id)->get();
        $scholarships->load('company_name', 'category', 'courses');

        return view('scholarshipprovider.setupscholarships.show', compact('scholarships','studentcourse'));
    }

    public function destroy(Setupscholarship $setupscholarship,$id)
    {
        
    	$setupscholarship=Scholarship::find($id);
        $setupscholarship->delete();

        return back();
    }

    public function massDestroy(MassDestroySetupscholarshipRequest $request)
    {
        Setupscholarship::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        

        $model         = new Setupscholarship();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function showprofile(StudentProfile $profile,$id,$scholarship_id)
    {
        $profile=StudentProfile::where('user_id',$id)->first();
        $s_id=$scholarship_id;
        //$scheme_id=$ss_id;
        //$results=DB::table('scholarship_user')->where('id',$scholarship_id)->first();
        $results=DB::table('scholarship_user')->where('id',$s_id)->first();
        $doc_results=DB::table('document_scholarship')->where('scholarship_id',$s_id)->join('documents', 'document_scholarship.documents_id', '=', 'documents.id')->get();
        $verifications=DB::table('verification_details')->where('s_id',$s_id)->get();
        //$profile= \DB::table('student_profiles')->where('user_id',$id)->first();
        return view('scholarshipprovider.applications.showprofile',compact('profile','s_id','results','doc_results','verifications'));
        //$profile=StudentProfile::where('user_id',$id)->first();
        //$profile= \DB::table('student_profiles')->where('user_id',$id)->first();
        //return view('scholarshipprovider.applications.showprofile',compact('profile'));
    }

       public function showapplications(Setupscholarship $scholarships,$id)
    {
       global $male,$female,$handicapped,$single_parent ;
        $male=0;$female=0;
        $handicapped=0;
        $single_parent=0;

       $scholarship=Scholarship::find($id);
       $results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
       $awarded=DB::table('scholarship_user')->where('scholarship_id',$id)->where('status','Awarded')
       ->get();
       $shortlist=DB::table('scholarship_user')->where('scholarship_id',$id)->where('status','Shortlised')
       ->get();

       foreach ($results as $result) {
            # code...
            
            if(StudentProfile::where('user_id',$result->user_id)->where('gender','male')->exists())
            {
                  $profiles=StudentProfile::where('user_id',$result->user_id)->where('gender','male')->first();
             
                   $male=$male+1;
            }
            elseif (StudentProfile::where('user_id',$result->user_id)->where('gender','female')->exists()) {
                # code...
                 $female=$female+1;
            }

            if(StudentProfile::where('user_id',$result->user_id)->where('handicapped','yes')->exists())
            {
                $profiles=StudentProfile::where('user_id',$result->user_id)->where('handicapped','yes')->first();
                $handicapped=$handicapped+1;
            }

            if (StudentProfile::where('user_id',$result->user_id)->where('single_parent','Yes')->exists()) {
                # code...
                $single_parent=$single_parent+1;
            }
          
        }


       return view('scholarshipprovider.applications.applicants',compact('results','scholarship','awarded','shortlist','male','female','handicapped','single_parent')); 
    }

    public function filteredview(Setupscholarship $scholarships,$id)
    {
       
        //$scholarship=Scholarship::select('id')->where('id',$id)->first();
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get()->chunk(50);
        $abc=DB::table('scholarship_user')->where('scholarship_id',$id)->pluck('user_id');
        $profiles=StudentProfile::whereIn('user_id',$abc)->select('id','fullname','gender','religion','handicapped','single_parent','current_state','permanent_state','course_type_id','course_name_id','current_year','user_id')->get();
        
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
       
        return view('scholarshipprovider.applications.filteredview',compact('s_id','profiles')); 
    }
    public function analyticsview(Setupscholarship $scholarships,$id)
    {
        global $fprofiles,$mprofiles,$other,$handicapped,$sp,$orphan,$bw50,$bw501,$bw5,$bw15,$bw3,$ab90,$ab80,$ab70,$ab60,$ab50,$ssc90,$ssc80,$scc70,$ssc60,$ssc50,$maharashtra,$aani,$andhp,$arup,$assam,$Bihar,$Chandigarh,$Chhattisgarh,$daman,$Delhi,$Goa,$Gujarat,$Haryana,$HimachalPradesh,$JK,$Jharkhand,$Karnataka,$Kerala,$Ladakh,$Lakshadweep,$MadhyaPradesh,$Manipur,$Meghalaya,$Mizoram,$Nagaland,$Odisha,$Puducherry,$Punjab,$Sikkim,$TamilNadu,$Telangana,$Tripura,$UttarPradesh,$Uttarakhand,$WestBengal,$Rajasthan,$course_scholarships,$coursedetails,$ab;
        $ab="";
        $coursedetails='';
        $course_scholarships="";
        $WestBengal=0;
        $Uttarakhand=0;
        $UttarPradesh=0;
        $Tripura=0;
        $Telangana=0;
        $TamilNadu=0;
        $Sikkim=0;
        $Rajasthan=0;
        $Puducherry=0;
        $Odisha=0;
        $Nagaland=0;
        $Mizoram=0;
        $Meghalaya=0;
        $Manipur=0;
        $MadhyaPradesh=0;
        $Lakshadweep=0;
        $Ladakh=0;
        $Kerala=0;
        $Karnataka=0;
        $Jharkhand=0;
        $JK=0;
        $HimachalPradesh=0;
        $Haryana=0;
        $Gujarat=0;
        $Goa=0;
        $Delhi=0;
        $daman=0;
        $Chhattisgarh=0;
        $Chandigarh=0;
        $Bihar=0;
        $assam=0;
        $arup=0;
        $andhp=0;
        $maharashtra=0;
        $aani=0;
        $fprofiles=0;
        $mprofiles=0;
        $other=0;
        $sp=0;
        $orphan=0;
        $handicapped=0;
        $bw50=0;
        $bw501=0;
        $bw502=0;
        $bw205=0;
        $bw5=0;
        $bw15=0;
        $bw3=0;
        $bw40=0;
        $ab60=0;
        $ab90=0;
        $ab80=0;
        $ab70=0;
        $ab40=0;
        $ssc90=0;
        $ssc80=0;
        $ssc70=0;
        $ssc60=0;
        $ssc50=0;
        $ssc40=0;
        $bwssc40=0;
        $awssc406=0;

        //$scholarship=Scholarship::find($id);
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $results=DB::table('scholarship_user')->where('scholarship_id',$id)->get()->chunk(50);
        $course=DB::table('course_scholarship')->where('scholarship_id',$id)->get();
        $course_scholarships=$course->unique();

        $count;
$genderCounts = [];

$genderCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->where('scholarship_user.scholarship_id', $s_id)
    ->selectRaw("CASE 
                    WHEN gender = 'male' THEN 'Male'
                    WHEN gender = 'female' THEN 'Female'
                    ELSE 'Others'
                END as gender_category, COUNT(*) as count")
    ->groupBy('gender_category')
    ->get();

//$maleCount = 0;
//$femaleCount = 0;
//$otherCount = 0;

foreach ($genderCounts as $count) {
    if ($count->gender_category === 'Male') {
        $mprofiles = $count->count;
    } elseif ($count->gender_category === 'Female') {
        $fprofiles = $count->count;
    } else {
        $other = $count->count;
    }
}

$handicapped = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->where('scholarship_user.scholarship_id', $s_id)
    ->where('student_profiles.handicapped', 'yes')
    ->count();
$sp = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->where('scholarship_user.scholarship_id', $s_id)
    ->where('student_profiles.single_parent', 'yes')
    ->count();
//echo "Male Count: " . $maleCount . "<br>";
//echo "Female Count: " . $femaleCount . "<br>";
//echo "Others Count: " . $otherCount . "<br>";
$orphan = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->where('scholarship_user.scholarship_id', $s_id)
    ->where('student_profiles.orphan', 'yes')
    ->count();

$incomeRanges = [
    [
        'range' => '0 - 50,000',
        'min' => 0,
        'max' => 50000
    ],
    [
        'range' => '50,000 - 2,00,000',
        'min' => 50000,
        'max' => 200000
    ],
    [
        'range' => '2,00,000 - 5,00,000',
        'min' => 200000,
        'max' => 500000
    ],
    [
        'range' => '5,00,000 and above',
        'min' => 500000,
        'max' => PHP_INT_MAX // Maximum integer value as the upper limit
    ]
];

$incomeCounts = [];

foreach ($incomeRanges as $range) {
    $incomeCount = DB::table('scholarship_user')
        ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
        ->where('scholarship_user.scholarship_id', $s_id)
        ->whereBetween('student_profiles.annual_income', [$range['min'], $range['max']])
        ->count();

    $incomeCounts[$range['range']] = $incomeCount;
}

// Store counts in separate variables
$bw50 = $incomeCounts['0 - 50,000'];
$bw502 = $incomeCounts['50,000 - 2,00,000'];
$bw205 = $incomeCounts['2,00,000 - 5,00,000'];
$bw5 = $incomeCounts['5,00,000 and above'];

$percentageRanges = [
    [
        'range' => '0 - 40',
        'min' => 0,
        'max' => 40
    ],
    [
        'range' => '41 - 60',
        'min' => 41,
        'max' => 60
    ],
    [
        'range' => '61 - 80',
        'min' => 61,
        'max' => 80
    ],
    [
        'range' => '81.00 and above',
        'min' => 81,
        'max' => 100
    ]
];

$percentageCounts = [];

foreach ($percentageRanges as $range) {
    $percentageCount = DB::table('scholarship_user')
        ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
        ->where('scholarship_user.scholarship_id', $s_id)
        ->whereBetween('student_profiles.previous_percentage', [$range['min'], $range['max']])
        ->count();

    $percentageCounts[$range['range']] = $percentageCount;
}

// Store counts in separate variables
$bw40 = $percentageCounts['0 - 40'];
$ab40 = $percentageCounts['41 - 60'];
$ab60 = $percentageCounts['61 - 80'];
$ab80 = $percentageCounts['81.00 and above'];


$percentageRanges = [
    [
        'range' => '0 - 40',
        'min' => 0,
        'max' => 40
    ],
    [
        'range' => '41 - 60',
        'min' => 41,
        'max' => 60
    ],
    [
        'range' => '61 - 80',
        'min' => 61,
        'max' => 80
    ],
    [
        'range' => '81.00 and above',
        'min' => 81,
        'max' => 100
    ]
];

$percentageCounts = [];

foreach ($percentageRanges as $range) {
    $percentageCount = DB::table('scholarship_user')
        ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
        ->where('scholarship_user.scholarship_id', $s_id)
        ->whereBetween('student_profiles.school_percentage', [$range['min'], $range['max']])
        ->count();

    $percentageCounts[$range['range']] = $percentageCount;
}

// Store counts in separate variables
$bwssc40 = $percentageCounts['0 - 40'];
$awssc406 = $percentageCounts['41 - 60'];
$ssc60 = $percentageCounts['61 - 80'];
$ssc80 = $percentageCounts['81.00 and above'];

/*
$stateCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->select('student_profiles.permanent_state', DB::raw('COUNT(*) as count'))
    ->where('scholarship_user.scholarship_id', $s_id)
    ->groupBy('student_profiles.permanent_state')
    ->get();

$stateData = [];
foreach ($stateCounts as $stateCount) {
    $state = $stateCount->permanent_state;
    $count = $stateCount->count;
    $stateData[$state] = $count;
}*/
$stateCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->select('student_profiles.permanent_state', DB::raw('COUNT(*) as count'))
    ->where('scholarship_user.scholarship_id', $s_id)
    ->groupBy('student_profiles.permanent_state')
    ->get();

//return $stateCounts;
$stateNames = [];
$stateCountsData = [];

foreach ($stateCounts as $stateCount) {
    $state = $stateCount->permanent_state;
    $count = $stateCount->count;

    $stateNames[] = $state;
    $stateCountsData[] = $count;
}

$courseTypeCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->join('coursetypes', 'student_profiles.course_type_id', '=', 'coursetypes.id')
    ->select('coursetypes.course_type_name', DB::raw('COUNT(*) as count'))
    ->where('scholarship_user.scholarship_id', $s_id)
    ->groupBy('coursetypes.course_type_name')
    ->get();

$courseTypeData = [];
foreach ($courseTypeCounts as $courseTypeCount) {
    $courseTypeName = $courseTypeCount->course_type_name;
    $coursecount = $courseTypeCount->count;
    
    $courseTypeData[$courseTypeName] = $coursecount;
}
$courseNameCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->join('student_courses', 'student_profiles.student_course_name_id', '=', 'student_courses.id')
    ->select('student_courses.course_name', DB::raw('COUNT(*) as count'))
    ->where('scholarship_user.scholarship_id', $s_id)
    ->groupBy('student_courses.course_name')
    ->get();

$courseNames = [];
$coursenameApplicationCounts = [];

foreach ($courseNameCounts as $courseNameCount) {
    $courseNames[] = $courseNameCount->course_name;
    $coursenameApplicationCounts[] = $courseNameCount->count;
}

$occupationCounts = DB::table('scholarship_user')
    ->join('student_profiles', 'scholarship_user.user_id', '=', 'student_profiles.user_id')
    ->select('student_profiles.father_occupation', DB::raw('COUNT(*) as count'))
    ->where('scholarship_user.scholarship_id', $s_id)
    ->groupBy('student_profiles.father_occupation')
    ->get();

$occupations = [];
$occupationCountData = [];

foreach ($occupationCounts as $occupationCount) {
    $occupation = $occupationCount->father_occupation;
    $count = $occupationCount->count;

    // Store occupation and count in separate variables
    $occupations[] = $occupation;
    $occupationCountData[] = $count;
}

//return $occupationCounts;


       
        return view('scholarshipprovider.applications.analyticsview',compact(
            'results','s_id','mprofiles','fprofiles','other','handicapped','sp','orphan','bw50','bw502','bw205','bw5','bw40','ab40','ab60','ab80','bwssc40','awssc406','ssc60','ssc80','state','count','courseTypeData','courseNames','coursenameApplicationCounts','courseNameCounts','occupationCounts','occupations','occupationCountData','stateCounts','stateNames','stateCountsData'
        ));
       
       // return view('scholarshipprovider.applications.analyticsview',compact('results','s_id','mprofiles','fprofiles','other','handicapped','sp','orphan','bw50','bw501','bw5','bw15','bw3','ab90','ab80','ab70','ab60','ab50','ssc90','ssc80','ssc70','ssc60','ssc50','maharashtra','aani','andhp','arup','assam','Bihar','Chandigarh','Chhattisgarh','daman','Delhi','Goa','Gujarat','Haryana','HimachalPradesh','JK','Jharkhand','Karnataka','Kerala','Ladakh','Lakshadweep','MadhyaPradesh','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Puducherry','Punjab','Sikkim','TamilNadu','Telangana','Tripura','UttarPradesh','Uttarakhand','WestBengal','Rajasthan','course_scholarships')); 
    }

    public function f1view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        

        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //$abc=DB::table('student_profiles')->where('user_id',$result->user_id)->where('gender','male')->pluck('id');
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('gender','male')->select('id','fullname','gender','user_id')->get();
        return view('scholarshipprovider.applications.f1view',compact('s_id','profiles','abc'));
    }

     public function f2view(Setupscholarship $scholarships,$id)
    {
        //$scholarships=Scholarship::find($id);

        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('gender','female')->select('id','fullname','gender','user_id')->get();
        return view('scholarshipprovider.applications.f2view',compact('s_id','profiles','abc'));
        
    }
    public function f3view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f3view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('gender','other')->select('id','fullname','gender','user_id')->get();
        return view('scholarshipprovider.applications.f3view',compact('s_id','profiles','abc'));
    }
    public function f4view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f4view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('single_parent','yes')->select('id','fullname','single_parent','user_id')->get();
        return view('scholarshipprovider.applications.f4view',compact('s_id','profiles','abc'));
    }
    public function f5view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f5view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('handicapped','yes')->select('id','fullname','handicapped','user_id')->get();
        return view('scholarshipprovider.applications.f5view',compact('s_id','profiles','abc'));
    }
    public function f6view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f6view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('orphan','yes')->select('id','fullname','orphan','user_id')->get();
        return view('scholarshipprovider.applications.f6view',compact('s_id','profiles','abc'));
    }

    public function f7view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f7view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('annual_income','<=','50000')->select('id','fullname','annual_income','user_id')->get();
        return view('scholarshipprovider.applications.f7view',compact('s_id','profiles','abc'));
    }
    public function f8view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f8view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('annual_income',[50000,100000])->select('id','fullname','annual_income','user_id')->get();
        return view('scholarshipprovider.applications.f8view',compact('s_id','profiles','abc'));
    }
    public function f9view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f9view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('annual_income',[100000,300000])->select('id','fullname','annual_income','user_id')->get();
        return view('scholarshipprovider.applications.f9view',compact('s_id','profiles','abc'));
    }
    public function f10view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f10view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('annual_income',[300000,500000])->select('id','fullname','annual_income','user_id')->get();
        return view('scholarshipprovider.applications.f10view',compact('s_id','profiles','abc'));
    }
    public function f11view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f11view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('annual_income',[500000,800000])->select('id','fullname','annual_income','user_id')->get();
        return view('scholarshipprovider.applications.f11view',compact('s_id','profiles','abc'));
    }
    public function f12view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f12view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('previous_percentage',[91,100])->select('id','fullname','previous_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f12view',compact('s_id','profiles','abc'));
    }
     public function f13view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f13view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('previous_percentage',[81,90])->select('id','fullname','previous_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f13view',compact('s_id','profiles','abc'));
    }
     public function f14view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f14view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('previous_percentage',[71,80])->select('id','fullname','previous_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f14view',compact('s_id','profiles','abc'));

    }
     public function f15view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f15view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('previous_percentage',[61,70])->select('id','fullname','previous_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f15view',compact('s_id','profiles','abc'));
    }
    public function f16view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f16view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->where('previous_percentage','<=','60')->select('id','fullname','previous_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f16view',compact('s_id','profiles','abc'));
    }
    public function f17view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f17view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('school_percentage',[91,100])->select('id','fullname','school_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f17view',compact('s_id','profiles','abc'));
    }
    public function f18view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f18view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('school_percentage',[81,90])->select('id','fullname','school_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f18view',compact('s_id','profiles','abc'));
    }
    public function f19view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f19view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('school_percentage',[71,80])->select('id','fullname','school_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f19view',compact('s_id','profiles','abc'));
    }
    public function f20view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f20view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('school_percentage',[61,70])->select('id','fullname','school_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f20view',compact('s_id','profiles','abc'));
    }
    public function f21view(Setupscholarship $scholarships,$id)
    {
        // $scholarship=Scholarship::find($id);
        //$scholarships=Scholarship::find($id);
        //$results=DB::table('scholarship_user')->where('scholarship_id',$id)->get();
        //return view('scholarshipprovider.applications.f21view',compact('results','scholarships'));
        $scholarships=Scholarship::select('id')->where('id',$id)->first();
        $s_id=$scholarships->id;
        $abc=DB::table('scholarship_user')->select('user_id')->where('scholarship_id',$id);
        $profiles=StudentProfile::whereIn('user_id',$abc)->whereBetween('school_percentage',[0,60])->select('id','fullname','school_percentage','user_id')->get();
        return view('scholarshipprovider.applications.f21view',compact('s_id','profiles','abc'));
    }


    public function promotion()
    {
        //$scholarships=Scholarship::where('')
        $scholarships = Scholarship::where('user_id',auth()->user()->id)->get();
         return view('scholarshipprovider.promotion.index',compact('scholarships'));
    }
}

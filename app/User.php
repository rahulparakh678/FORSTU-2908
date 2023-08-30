<?php
namespace App;
//use Carbon\Carbon;
//use Illuminate\Auth\Notifications\ResetPassword;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use App\Traits\Authenticatable; 
//use App\Traits\Authenticatable as UserAuthenticatable;

//use Illuminate\Notifications\Notifiable;
//use Laravel\Passport\HasApiTokens;
//use App\Notifications\VerifyMobileNotification;

//use App\Traits\MustVerifyMobile;
//use Illuminate\Support\Facades\URL;


//use Laravel\Passport\HasApiTokens;
//use \DateTimeInterface;

//namespace App\Traits;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use App\Traits\Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyMobileNotification;
use Illuminate\Support\Facades\URL;
//use Laravel\Passport\HasApiTokens;
use DateTimeInterface;

/*
trait MustVerifyMobile
{
    public function sendMobileVerificationNotification()
    {
        $url = $this->verificationUrl();
        $this->notify(new VerifyMobileNotification($url));
    }

    public function verificationUrl()
    {
        return URL::temporarySignedRoute(
            'verification.mobile.verify',
            now()->addMinutes(60),
            ['id' => $this->id]
        );
    }
}*/

//class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable 

{
    //use SoftDeletes, Notifiable,HasFactory,HasApiTokens,MustVerifyMobile;
     //use AuthenticatableTrait;
      //use HasFactory, Notifiable,Authenticatable;
    //use UserAuthenticatable;
    use Notifiable;
    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'user_type',
        'mobile',
        'gender',
        'email_verified_at',
        'ref_code',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'state',
        'course',
        'college',
        'caste',
        'current_year',
        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(StudentProfile::class);
    }
    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class)->withTimestamps();
    }
    public function student_course_name()
    {
        return $this->belongsTo(StudentCourses::class,'student_course_name_id');
    }
    public function course_type()
    {
        return $this->belongsTo(Coursetype::class, 'course_type_id');
    }
}   
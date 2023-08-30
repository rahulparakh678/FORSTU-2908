<?php

namespace App\Imports;

use App\StudentProfile;
use Maatwebsite\Excel\Concerns\ToModel;
//use App\Imports\Carbon;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentProfileImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $dateFormat = 'Y-m-d';
    public function model(array $row)
    {
           // $userId = isset($row['user_id']) ? $row['user_id'] : null;
            //$parentsMobile = isset($row['parents_mobile']) ? $row['parents_mobile'] : null;
            $getValueOrNull = function ($key) use ($row) {
                return isset($row[$key]) ? $row[$key] : null;
            };
        return new StudentProfile([
        'fullname' => $getValueOrNull('fullname'),
        'email' => $getValueOrNull('email'),
        'mobile' => $getValueOrNull('mobile'),
        'gender' => $getValueOrNull('gender'),
        'ref_code' => $getValueOrNull('ref_code'),
        'user_id' => $getValueOrNull('user_id'),
        'religion' => $getValueOrNull('religion'),
        'handicapped' => $getValueOrNull('handicapped'),
        'single_parent' => $getValueOrNull('single_parent'),
        'aadharnumber' => $getValueOrNull('aadharnumber'),
        'father_name' => $getValueOrNull('father_name'),
        'father_edu' => $getValueOrNull('father_edu'),
        'father_occupation' => $getValueOrNull('father_occupation'),
        'mother_name' => $getValueOrNull('mother_name'),
        'mother_edu' => $getValueOrNull('mother_edu'),
        'mothers_occupation' => $getValueOrNull('mothers_occupation'),
        'parents_mobile' => $getValueOrNull('parents_mobile'),
        'annual_income' => $getValueOrNull('annual_income'),
        'current_add' => $getValueOrNull('current_add'),
        'current_state' => $getValueOrNull('current_state'),
        'current_city' => $getValueOrNull('current_city'),
        'pincode' => $getValueOrNull('pincode'),
        'permanent_add' => $getValueOrNull('permanent_add'),
        'permanent_city' => $getValueOrNull('permanent_city'),
        'permanent_pincode' => $getValueOrNull('permanent_pincode'),
        'permanent_state' => $getValueOrNull('permanent_state'),
        'account_number' => $getValueOrNull('account_number'),
        'bank_ifsc' => $getValueOrNull('bank_ifsc'),
        'current_inst_name' => $getValueOrNull('current_inst_name'),
        'current_year' => $getValueOrNull('current_year'),
        'tution_fees' => $getValueOrNull('tution_fees'),
        'non_tution_fees' => $getValueOrNull('non_tution_fees'),
        'hostel_fees' => $getValueOrNull('hostel_fees'),
        'previous_marks_obtained' => $getValueOrNull('previous_marks_obtained'),
        'previous_marks_total' => $getValueOrNull('previous_marks_total'),
        'previous_percentage' => $getValueOrNull('previous_percentage'),
        'class_10_school_name' => $getValueOrNull('class_10_school_name'),
        'class_10_state' => $getValueOrNull('class_10_state'),
        'school_marks_obtained' => $getValueOrNull('school_marks_obtained'),
        'school_marks_total' => $getValueOrNull('school_marks_total'),
        'cgpa_school_marks_obtained' => $getValueOrNull('cgpa_school_marks_obtained'),
        'cgpa_school_marks_total' => $getValueOrNull('cgpa_school_marks_total'),
        'school_percentage' => $getValueOrNull('school_percentage'),
        'class_12_clg_name' => $getValueOrNull('class_12_clg_name'),
        'class_12_state' => $getValueOrNull('class_12_state'),
        'class_12_marks_obtained' => $getValueOrNull('class_12_marks_obtained'),
        'class_12_out_of_total_marks' => $getValueOrNull('class_12_out_of_total_marks'),
        'class_12_percentage' => $getValueOrNull('class_12_percentage'),
        'cgpa_class_12_marks_obtained' => $getValueOrNull('cgpa_class_12_marks_obtained'),
        'cgpa_class_12_marks_total' => $getValueOrNull('cgpa_class_12_marks_total'),
        'diploma_clg_name' => $getValueOrNull('diploma_clg_name'),
        'diploma_state' => $getValueOrNull('diploma_state'),
        'diploma_total_marks_obtained' => $getValueOrNull('diploma_total_marks_obtained'),
        'diploma_out_of_total_marks' => $getValueOrNull('diploma_out_of_total_marks'),
        'diploma_percentage' => $getValueOrNull('diploma_percentage'),
        'cgpa_diploma_marks_obtained' => $getValueOrNull('cgpa_diploma_marks_obtained'),
        'cgpa_diploma_marks_total' => $getValueOrNull('cgpa_diploma_marks_total'),
        'grad_clg_name' => $getValueOrNull('grad_clg_name'),
        'grad_state' => $getValueOrNull('grad_state'),
        'grad_total_marks' => $getValueOrNull('grad_total_marks'),
        'grad_out_of_total_marks' => $getValueOrNull('grad_out_of_total_marks'),
        'cgpa_grad_marks_obtained' => $getValueOrNull('cgpa_grad_marks_obtained'),
        'cgpa_grad_marks_total' => $getValueOrNull('cgpa_grad_marks_total'),
        'grad_percentage' => $getValueOrNull('grad_percentage'),
        'caste_id' => $getValueOrNull('caste_id'),
        'course_type_id' => $getValueOrNull('course_type_id'),
        'course_name_id' => $getValueOrNull('course_name_id'),
        'student_course_name_id' => $getValueOrNull('student_course_name_id'),
        'ref_code' => $getValueOrNull('ref_code'),
        // ... continue for the rest of the fields ...
        ]);
    }
}

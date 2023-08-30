<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    public $table = 'verification_details';
    protected $fillable = [
        'user_id',
        'verification_type',
        'status',
        'remark',
        'reference_link',
        's_id'
    ];
}

?>
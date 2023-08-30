<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Ticket extends Model
{
    //
     use SoftDeletes;

    public $table = 'tickets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'Open'   => 'Open',
        'Closed' => 'Closed',
    ];

    protected $fillable = [
        'userid',
        'categoryid_id',
        'query',
        'status',
        'response',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function categoryid()
    {
        return $this->belongsTo(Ticketcategory::class, 'categoryid_id');
    }
}

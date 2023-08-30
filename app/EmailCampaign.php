// app/Models/EmailCampaign.php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'scholarship_id',
        'name',
        'total_recipients',
        'total_delivered',
        'total_bounced',
        'open_rate',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}

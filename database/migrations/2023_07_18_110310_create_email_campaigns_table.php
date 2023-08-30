// database/migrations/YYYY_MM_DD_HHmmss_create_email_campaigns_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scholarship_id');
            $table->string('name');
            $table->unsignedInteger('total_recipients');
            $table->unsignedInteger('total_delivered')->nullable();
            $table->unsignedInteger('total_bounced')->nullable();
            $table->float('open_rate')->nullable();
            $table->timestamps();

            $table->foreign('scholarship_id')->references('id')->on('scholarships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_campaigns');
    }
}
?>
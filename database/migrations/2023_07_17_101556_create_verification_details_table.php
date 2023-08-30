<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('verification_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('s_id');
            $table->string('verification_type');
            $table->string('status');
            $table->text('remark')->nullable();
            $table->string('reference_link')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('s_id')->references('id')->on('scholarships')->onDelete('cascade');
        });
    }

    // ...
}
?>

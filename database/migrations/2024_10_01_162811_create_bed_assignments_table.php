<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_assignments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bed_id');
            $table->bigInteger('profile_id');
            $table->string('term');
            $table->bigInteger('process_by');
            $table->string('status')->default('Rented'); // Rented, Paid
            $table->date('check_in');
            $table->date('check_out')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->index(['profile_id','bed_id','process_by']);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bed_assignments');
    }
};

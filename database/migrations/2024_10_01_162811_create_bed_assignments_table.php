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
            $table->integer('bed_id');
                $table->foreign('bed_id')->references('id')->on('beds')->onDelete('restrict');
            $table->integer('profile_id');
                $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('restrict');
            $table->string('occupation_type');
            $table->integer('process_by');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->timestamps();
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

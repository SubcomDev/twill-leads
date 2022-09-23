<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTables extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->dateTime('exported_at')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
            $table->timestamp('published')->nullable();
        });

    }

    public function down()
    {

        Schema::dropIfExists('leads');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('username')->unique();
            $table->string('name');
            $table->enum('gender', ['Woman', 'Man', 'None'])->nullable('None');
            $table->date('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->string('vision')->nullable();
            $table->string('mission')->nullable();
            $table->enum('role', ['User', 'Admin', 'Voter', 'Candidate', 'Super admin'])->default('User');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

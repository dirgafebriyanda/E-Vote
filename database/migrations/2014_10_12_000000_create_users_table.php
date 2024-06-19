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
            $table->enum('jekel', ['Perempuan', 'Laki-laki', 'None'])->nullable('None');
            $table->date('tgl_lahir')->nullable();
            $table->string('email')->unique();
            $table->string('visi')->nullable();
            $table->string('misi')->nullable();
            $table->enum('role', ['User', 'Admin', 'Super admin'])->default('User');
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

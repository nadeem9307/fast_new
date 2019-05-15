<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email',100)->unique()->nullable();
            $table->string('password');
            $table->bigInteger('contact')->nullable();
            $table->string('school_name')->nullable();
            $table->integer('refer_id')->nullable();
            $table->integer('country_id')->unsigned();
            $table->text('avatar')->nullable();
            $table->text('instructor_avatar')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['1', '2'])->nullable()->comment('male->1, female->2');
            $table->integer('level_id')->unsigned();
            $table->tinyInteger('fast_score')->default('0');
            $table->string('fast_key')->nullable();
            $table->enum('user_type', ['1', '2', '3'])->nullable()->comment('admin->1, parent_user->2, child_user->3');
            $table->enum('status', ['1', '2'])->default('1')->comment('Active->1, Archive->2');
            $table->enum('logged_in', ['1', '2'])->default('2')->comment('1=> Logged , 2=> Not Logged');
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotification extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->text('message')->nullable();
            $table->enum('request_type', ['1', '2', '3', '4'])->comment('1->Child, 2->Friend, 3->RetakeTest, 4->Declined');
            $table->enum('status', ['1', '2'])->default('2')->comment('1->Read, 2->Unread');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_notification');
    }

}

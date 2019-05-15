<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionFileUpload extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('question_file_upload', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name', 100);
            $table->integer('start_from');
            $table->integer('end_from');
            $table->text('settings');
            $table->enum('user_type', ['2', '3'])->comment('Parent->2, Child->3');
            $table->integer('uploaded_by');
            $table->integer('last_inserted_question_id');
            $table->enum('status', ['1', '2'])->default('1')->comment('active->1, complete->2');
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
        Schema::dropIfExists('question_file_upload');
    }

}

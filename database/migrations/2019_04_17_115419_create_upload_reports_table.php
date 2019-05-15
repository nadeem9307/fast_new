<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadReportsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('upload_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uploaded_id')->unsigned();
            $table->enum('error_type', ['1', '2'])->comment('Question->1, Options->2');
            $table->text('row_line');
            $table->text('error');  
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('uploaded_id')->references('id')->on('question_file_upload')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('upload_reports');
    }

}

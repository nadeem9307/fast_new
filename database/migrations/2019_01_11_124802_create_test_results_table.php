<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('test_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('score')->nullable();
            $table->integer('level_id')->unsigned();
            $table->integer('sublevel_id')->unsigned();
            $table->integer('sem_id')->unsigned();
            $table->text('answer')->nullable();
            $table->text('categories_result')->nullable();
            $table->text('overall_interpretation')->nullable();
            $table->time('duration')->nullable();
            $table->enum('status', ['1', '2'])->default('1')->comment('Active->1, Inactive->2');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sublevel_id')->references('id')->on('sublevels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sem_id')->references('id')->on('semesters')->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::unprepared('DROP TRIGGER IF EXISTS update_user_fast_score');
        DB::unprepared('
            CREATE TRIGGER update_user_fast_score AFTER INSERT ON fi_test_results FOR EACH ROW
            BEGIN
            SET @fast_score = 0;

            SELECT IFNULL(ROUND(SUM(fast_score)),0) INTO @fast_score FROM fi_user_fast_score WHERE fi_user_fast_score.user_id = NEW.user_id;
                            
            IF(@fast_score!=0) THEN
            UPDATE fi_users SET fi_users.fast_score = @fast_score WHERE fi_users.id = NEW.user_id;
            END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('test_results');
    }

}

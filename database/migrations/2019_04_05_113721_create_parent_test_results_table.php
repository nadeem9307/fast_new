<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_test_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('score')->nullable();
            $table->text('answer')->nullable();
            $table->text('categories_result')->nullable();
            $table->text('overall_interpretation')->nullable();
            $table->time('duration')->nullable();
            $table->text('long_summary')->nullable();
            $table->enum('status', ['1', '2'])->default('1')->comment('Active->1, Inactive->2');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::unprepared('DROP TRIGGER IF EXISTS update_country_result');
        DB::unprepared('
            CREATE TRIGGER update_country_result AFTER INSERT ON fi_parent_test_results FOR EACH ROW
            BEGIN
            SET @cur_score = null;
            SET @usr_con = null;

            SELECT country_id INTO @usr_con FROM `fi_users` WHERE id = NEW.user_id;

            SELECT fi_score.score INTO @cur_score FROM fi_country_score AS fi_score WHERE fi_score.country_id = @usr_con;
            UPDATE fi_users SET fi_users.fast_score = NEW.score WHERE fi_users.id = NEW.user_id;

            IF(@cur_score IS NOT NULL) THEN
                UPDATE fi_country_score SET total_attempts=(total_attempts+1),score= FLOOR((score + ((NEW.score - score) / total_attempts))) WHERE country_id = @usr_con;
            ELSEIF(@cur_score IS NULL) THEN 
                INSERT INTO fi_country_score SET score=NEW.score, total_attempts=1, country_id = @usr_con;
            END IF;
            END
        ');

        DB::unprepared('DROP VIEW IF EXISTS fi_country_wise_score');
        DB::unprepared("
            CREATE VIEW fi_country_wise_score 
            AS
            select `res`.`user_id` AS `user_id`,`fi_users`.`username` AS `username`,`fi_users`.`user_type` AS `user_type`,`fi_countries`.`id` AS `country_id`,`fi_countries`.`country_name` AS `country_name`,(select `tres`.`score` from `fi_parent_test_results` `tres` where (`tres`.`user_id` = `res`.`user_id`) order by `tres`.`id` desc limit 1) AS `res_score`,`res`.`created_at` AS `test_date` from ((`fi_parent_test_results` `res` join `fi_users` on((`fi_users`.`id` = `res`.`user_id`))) join `fi_countries` on((`fi_countries`.`id` = `fi_users`.`country_id`))) group by `res`.`user_id` order by `res_score` desc
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_test_results');
    }
}

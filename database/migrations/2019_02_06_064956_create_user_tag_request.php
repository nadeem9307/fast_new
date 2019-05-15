<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTagRequest extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_tag_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->enum('request_status', ['1', '2', '3'])->default('1')->comment('1->Pending, 2->Approved, 3->Declined');
            $table->enum('request_type', ['1', '2'])->comment('1->Child, 2->Friend');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
        /*DB::unprepared('DROP VIEW IF EXISTS fi_country_wise_score');
        DB::unprepared("
            CREATE VIEW fi_country_wise_score 
            AS
            select `res`.`user_id` AS `user_id`,`fi_users`.`username` AS `username`,`fi_users`.`user_type` AS `user_type`,`fi_countries`.`id` AS `country_id`,`fi_countries`.`country_name` AS `country_name`,(select `tres`.`score` from `fi_test_results` `tres` where (`tres`.`user_id` = `res`.`user_id`) order by `tres`.`score` desc limit 1) AS `res_score`,`res`.`created_at` AS `test_date` from ((`fi_test_results` `res` join `fi_users` on((`fi_users`.`id` = `res`.`user_id`))) join `fi_countries` on((`fi_countries`.`id` = `fi_users`.`country_id`))) group by `res`.`user_id` order by `res_score` desc
        ");*/
        DB::unprepared('DROP VIEW IF EXISTS fi_user_level_data');
        DB::unprepared("
            CREATE VIEW fi_user_level_data 
            AS
            select `fi_users`.`id` AS `userId`,`fi_users`.`level_id` AS `user_level`,(select `fi_sublevels`.`id` from `fi_sublevels` order by `fi_sublevels`.`priority` limit 1) AS `first_sublevel`,(select `fi_test_results`.`sublevel_id` from (((`fi_test_results` join `fi_users` on((`fi_test_results`.`user_id` = `fi_test_results`.`user_id`))) join `fi_sublevels` on((`fi_sublevels`.`id` = `fi_test_results`.`sublevel_id`))) join `fi_semesters` on((`fi_semesters`.`id` = `fi_test_results`.`sem_id`))) where ((`fi_test_results`.`level_id` = `user_level`) and (`fi_test_results`.`user_id` = `userId`)) order by `fi_sublevels`.`priority` desc,`fi_semesters`.`priority` desc,`fi_test_results`.`created_at` desc limit 0,1) AS `last_sublevel`,(select `fi_test_results`.`sem_id` from (((`fi_test_results` join `fi_users` on((`fi_test_results`.`user_id` = `fi_test_results`.`user_id`))) join `fi_sublevels` on((`fi_sublevels`.`id` = `fi_test_results`.`sublevel_id`))) join `fi_semesters` on((`fi_semesters`.`id` = `fi_test_results`.`sem_id`))) where ((`fi_test_results`.`level_id` = `user_level`) and (`fi_test_results`.`user_id` = `userId`)) order by `fi_sublevels`.`priority` desc,`fi_semesters`.`priority` desc,`fi_test_results`.`created_at` desc limit 0,1) AS `last_sem`,(select ifnull(`last_sublevel`,`first_sublevel`)) AS `current_sublevel`,(select ifnull(`last_sem`,(select `fi_semesters`.`id` from `fi_semesters` where (`fi_semesters`.`sublevel_id` = `current_sublevel`) order by `fi_semesters`.`priority` limit 1))) AS `current_sem` from `fi_users` where (`fi_users`.`user_type` = 3)
        ");
        DB::unprepared('DROP VIEW IF EXISTS fi_part_wise_contribution');
        DB::unprepared("
            CREATE VIEW fi_part_wise_contribution 
            AS
            select `fi_sublevels`.`id` AS `sublevelId`,(select count(`fi_semesters`.`id`) from `fi_semesters` where ((`fi_semesters`.`sublevel_id` = `sublevelId`) and (`fi_semesters`.`status` = '1'))) AS `total_sem`,(select count(`fi_levels`.`id`) from `fi_levels` where (`fi_levels`.`status` = '1')) AS `total_level`,(select count(`fi_sublevels`.`id`) from `fi_sublevels` where (`fi_sublevels`.`status` = '1')) AS `total_sub`,(select (100 / ((`total_level` * `total_sub`) * `total_sem`))) AS `part_contribution` from `fi_sublevels`
        ");
        DB::unprepared('DROP VIEW IF EXISTS fi_user_fast_score');
        DB::unprepared("
            CREATE VIEW fi_user_fast_score 
            AS
            select `fi_users`.`id` AS `user_id`,`fi_users`.`country_id` AS `country_id`,`fi_levels`.`id` AS `level_id`,`fi_semesters`.`sublevel_id` AS `sublevel_id`,`fi_semesters`.`id` AS `sem_id`,ifnull((select `fi_test_results`.`score` from `fi_test_results` where ((`fi_test_results`.`user_id` = `fi_users`.`id`) and (`fi_test_results`.`level_id` = `fi_levels`.`id`) and (`fi_test_results`.`sublevel_id` = `fi_semesters`.`sublevel_id`) and (`fi_test_results`.`sem_id` = `fi_semesters`.`id`)) order by `fi_test_results`.`id` desc limit 1),'0') AS `test_score`,(select `fi_test_results`.`id` from `fi_test_results` where ((`fi_test_results`.`user_id` = `fi_users`.`id`) and (`fi_test_results`.`level_id` = `fi_levels`.`id`) and (`fi_test_results`.`sublevel_id` = `fi_semesters`.`sublevel_id`) and (`fi_test_results`.`sem_id` = `fi_semesters`.`id`)) order by `fi_test_results`.`id` desc limit 1,1) AS `prev_test_id`,(select `fi_test_results`.`score` from `fi_test_results` where ((`fi_test_results`.`user_id` = `fi_users`.`id`) and (`fi_test_results`.`level_id` = `fi_levels`.`id`) and (`fi_test_results`.`sublevel_id` = `fi_semesters`.`sublevel_id`) and (`fi_test_results`.`sem_id` = `fi_semesters`.`id`) and (`fi_test_results`.`id` = `prev_test_id`)) order by `fi_test_results`.`id` desc limit 1) AS `prev_score`,(select `fi_test_results`.`id` from `fi_test_results` where ((`fi_test_results`.`user_id` = `fi_users`.`id`) and (`fi_test_results`.`level_id` = `fi_levels`.`id`) and (`fi_test_results`.`sublevel_id` = `fi_semesters`.`sublevel_id`) and (`fi_test_results`.`sem_id` = `fi_semesters`.`id`)) order by `fi_test_results`.`id` desc limit 2,1) AS `last_test_id`,(select `fi_test_results`.`score` from `fi_test_results` where ((`fi_test_results`.`user_id` = `fi_users`.`id`) and (`fi_test_results`.`level_id` = `fi_levels`.`id`) and (`fi_test_results`.`sublevel_id` = `fi_semesters`.`sublevel_id`) and (`fi_test_results`.`sem_id` = `fi_semesters`.`id`) and (`fi_test_results`.`id` = `last_test_id`)) order by `fi_test_results`.`id` desc limit 1) AS `last_test_score`,(select ((`test_score` * (select `fi_part_wise_contribution`.`part_contribution` from `fi_part_wise_contribution` where (`fi_part_wise_contribution`.`sublevelId` = `fi_semesters`.`sublevel_id`))) / 100)) AS `fast_score` from ((`fi_users` join `fi_levels`) join `fi_semesters`) where (`fi_users`.`user_type` = 3)
        ");
        DB::unprepared('DROP VIEW IF EXISTS fi_user_country_wise_score_old');
        DB::unprepared("
            CREATE VIEW fi_user_country_wise_score_old 
            AS
            select `fi_user_fast_score`.`user_id` AS `user_id`,`fi_users`.`username`,`fi_users`.`user_type`,`fi_user_fast_score`.`country_id` AS `country_id`,`fi_countries`.`country_name`,ROUND(sum(`fi_user_fast_score`.`fast_score`)) AS `fast_score` from (`fi_user_fast_score` join `fi_users` on((`fi_users`.`id` = `fi_user_fast_score`.`user_id`)) join `fi_countries` on ((`fi_countries`.`id` = `fi_users`.`country_id`))) group by `fi_user_fast_score`.`user_id`
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_tag_request');
    }

}

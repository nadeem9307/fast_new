<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('levels')->insert(array(
            0 =>
            array(
                'level_name' => 'BASIC',
                'priority' => 1,
            ),
            1 =>
            array(
                'level_name' => 'JUNIOR',
                'priority' => 2,
            ),
            2 =>
            array(
                'level_name' => 'APPRENTICE',
                'priority' => 3,
            ),
        ));
        DB::table('sublevels')->insert(array(
            0 =>
            array(
                'sublevel_name' => 'BEGINNER',
                'priority' => 1,
            ),
            1 =>
            array(
                'sublevel_name' => 'INTERMEDIATE',
                'priority' => 2,
            ),
            2 =>
            array(
                'sublevel_name' => 'ADVANCE',
                'priority' => 3,
            ),
        ));
        DB::unprepared("
                INSERT INTO `fi_semesters` (`id`, `sublevel_id`, `sem_name`, `priority`, `status`, `created_at`, `updated_at`) VALUES
        (1, 1, 'Sem1', 1, '1', '2019-03-14 08:43:41', '2019-03-14 08:43:41'),
        (2, 1, 'Sem2', 2, '1', '2019-03-14 08:43:49', '2019-03-14 08:43:49'),
        (3, 2, 'Sem3', 3, '1', '2019-03-14 08:43:57', '2019-03-14 08:43:57'),
        (4, 2, 'Sem4', 4, '1', '2019-03-14 08:44:04', '2019-03-14 08:44:04'),
        (5, 3, 'Sem5', 5, '1', '2019-03-14 08:44:13', '2019-03-14 08:44:13'),
        (6, 3, 'Sem6', 6, '1', '2019-03-14 08:44:19', '2019-03-14 08:44:19');
                ");
        DB::table('categories')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_name' => 'Knowledge',
                'status' => 1,
                'level_id' =>1,
            ),
            1 =>
            array(
                'id' => 2,
                'category_name' => 'Habits',
                'level_id' =>1,
                'status' => 1,
            ),
            2 =>
            array(
                'id' => 3,
                'category_name' => 'Social Pressure Defence',
                'level_id' =>1,
                'status' => 1,
            ),
        ));
        

        DB::table('parent_categories')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_name' => 'Knowledge',
                'status' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'category_name' => 'Habits',
                'status' => 1,
            ),
            2 =>
            array(
                'id' => 3,
                'category_name' => 'Social Pressure Defence',
                'status' => 1,
            ),
        ));
    }

}

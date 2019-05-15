<?php

use Illuminate\Database\Seeder;

class TestResultTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('test_results')->insert([
            ['id' => '1',
                'user_id' => '2',
                'score' => '90',
                'answer' => '[{"category_id":"1","0":{"question_id":"1","given_options":"A","correct_options":"B"},"1":{"question_id":"2","given_options":"B","correct_options":"B"},"2":{"question_id":"3","given_options":"C","correct_options":"B"},"3":{"question_id":"4","given_options":"C","correct_options":"C"},"4":{"question_id":"5","given_options":"B","correct_options":"B"}},{"category_id":"2","0":{"question_id":"6","given_options":"A","correct_options":"B"},"1":{"question_id":"7","given_options":"B","correct_options":"B"},"2":{"question_id":"8","given_options":"C","correct_options":"B"},"3":{"question_id":"9","given_options":"C","correct_options":"C"},"4":{"question_id":"10","given_options":"A","correct_options":"A"}},{"category_id":"3","0":{"question_id":"11","given_options":"A","correct_options":"B"},"1":{"question_id":"12","given_options":"B","correct_options":"B"},"2":{"question_id":"13","given_options":"C","correct_options":"B"},"3":{"question_id":"14","given_options":"B","correct_options":"C"},"4":{"question_id":"15","given_options":"A","correct_options":"A"}}]',
                'status' => '1'
            ]
        ]);
    }

}

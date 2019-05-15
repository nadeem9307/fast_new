<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ParentQuestions extends Model {

    public $table = "parent_questions";

    protected $fillable = [
        'category_id', 'question_name', 'question_type',
    ];

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get all questions data.
     * @params  : none
     * @return  : questions
     */

    public static function getAllQuestion($perpage, $page, $offset, $draw, $question_list) {
        $question = new ParentQuestions();
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $question = \DB::table("parent_questions")
                ->join('countries', \DB::raw("FIND_IN_SET(fi_countries.id,fi_parent_questions.country_id)"), ">", \DB::raw("'0'"))
                ->join('parent_categories', 'parent_categories.id', '=', 'parent_questions.category_id')
                ->select(DB::raw('@rownumber:=@rownumber+1 as S_No'), 'parent_questions.id as id', 'parent_questions.question_name', 'parent_questions.country_id', 'parent_questions.category_id', 'parent_categories.category_name', 'parent_questions.question_type', 'parent_questions.file_attached', 'parent_questions.status', \DB::raw("GROUP_CONCAT(fi_countries.country_name) as country_name"))
                ->groupBy('parent_questions.id', 'parent_questions.question_name', 'parent_questions.country_id', 'parent_questions.question_type', 'parent_categories.category_name', 'parent_questions.question_type', 'parent_questions.file_attached', 'parent_questions.status', 'parent_questions.category_id');


        if ($question_list != '') {
            $question = $question->where('parent_questions.category_id', $question_list);
        }
        $total = $question->count();
        $question = $question->get();
        return $question;
    }

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question fill blanks type data.
     * @params  : none
     * @return  : true
     */

    public static function save_question_fill_blanks($request, $answers) {
        if (isset($request->fill_question_id)) {
            $del_ans = ParentAnswers::where('question_id', $request->fill_question_id);
            $del_ans->delete();
            $question = ParentQuestions::find($request->fill_question_id);
            $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->fill_question_input)));
        } else {
            $question = new ParentQuestions();
        }

        if ($request->hasFile('fill_attached_file')) {
            $image = $request->fill_attached_file;
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $type = strtolower($image->getClientOriginalExtension());
            $allowed = array('jpg', 'png', 'jpeg', 'mp3', 'mp4');
            if (!in_array($type, $allowed)) {

                return array('status' => 'error', 'message' => 'Please select only image jpg,png,jpeg format Audio in mp3 and video only');
            }
          
            $path = storage_path('app/parent_questions');
            $image->move($path, $filename);

            $image_name = $filename;
            $question->file_attached = $image_name;
        }
        if (is_array($request->fill_country_id)) {
            $string = '';
            $string = implode(",", array_filter($request->fill_country_id));
         
            $question->country_id = $string;
        } else {
            $question->country_id = $request->fill_country_id;
        }
        $question->category_id = $request->fill_category_id;
        $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->fill_question_input)));
        $question->question_type = 1;
      
        if ($question->save()) {
            $last_insert_id = $question->id;
        }
        foreach ($answers as $fill_ans) {
            $answer = new ParentAnswers();

            if (strlen($fill_ans) > 0) {
                $answer->question_id = $last_insert_id;
                $answer->correct_options = htmlentities(str_replace('"', '&quot;', trim($fill_ans)));
               
                if ($answer->save()) {
                    
                } else {
                    return array('status' => 'error', 'message' => 'Failed to Add Question');
                }
            }
        }
        return array('status' => 'success', 'message' => 'Question successfully saved');
    }

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question fill blanks type data.
     * @params  : none
     * @return  : true
     */

    public static function save_question_multi_choice($options, $correct_answer, $request) {
        if (in_array("1", $correct_answer)) {
            if (isset($request->multi_question_id)) {
                $del_ans = ParentAnswers::where('question_id', $request->multi_question_id);
                $del_ans->delete();

                $question = ParentQuestions::find($request->multi_question_id);
                $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->multi_question_input)));
            } else {
                $question = new ParentQuestions();
            }
            if ($request->hasFile('multi_attached_file')) {
                $image = $request->multi_attached_file;
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $type = strtolower($image->getClientOriginalExtension());
                $allowed = array('jpg', 'png', 'jpeg', 'mp3', 'mp4');
                if (!in_array($type, $allowed)) {
                    return array('status' => 'error', 'message' => 'Please select only image jpg,png,jpeg format Audio in mp3 and video only');
                }
                $path = storage_path('app/parent_questions');
                $image->move($path, $filename);

                $image_name = $filename;
                $question->file_attached = $image_name;
            }
            if (is_array($request->multi_country_id)) {
                $string = '';
                $string = implode(",", array_filter($request->multi_country_id));

                $question->country_id = $string;
            } else {
                $question->country_id = $request->multi_country_id;
            }
            $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->multi_question_input)));
            $question->category_id = $request->multi_category_id;
            $question->question_type = 2;
            if ($question->save()) {
                $last_insert_id = $question->id;
            }
            foreach ($options as $index => $option) {
                $answer = new ParentAnswers();
                $answer->question_id = $last_insert_id;
                $answer->options = htmlentities(str_replace('"', '&quot;', trim($option)));

                if ($correct_answer[$index] == 1) {
                    $answer->correct_options = $correct_answer[$index];
                } else {
                    $answer->correct_options = 0;
                }
                if ($answer->save()) {   
                } else {
                    return array('status' => 'error', 'message' => 'Failed to Add Question');
                }
            }
            return array('status' => 'success', 'message' => 'Question successfully saved');
        } else {
            return array('status' => 'error', 'message' => 'Check correct answer(s)');
        }
    }

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question arrange order data.
     * @params  : none
     * @return  : true
     */

    public static function save_question_arrange_order($incorrect_order, $correct_order, $request) {
        if (isset($request->arrange_question_id)) {
            $del_ans = ParentAnswers::where('question_id', $request->arrange_question_id);
            $del_ans->delete();
            $question = ParentQuestions::find($request->arrange_question_id);
            $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->arrange_question_input)));
        } else {
            $question = new ParentQuestions();
        }
        if ($request->hasFile('arrange_attached_file')) {
            $image = $request->arrange_attached_file;
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $type = strtolower($image->getClientOriginalExtension());
            $allowed = array('jpg', 'png', 'jpeg', 'mp3', 'mp4');
            if (!in_array($type, $allowed)) {
                return array('status' => 'error', 'message' => 'Please select only image jpg,png,jpeg format Audio in mp3 and video only');
            }
            $path = storage_path('app/parent_questions');
            $image->move($path, $filename);
            $image_name = $filename;
            $question->file_attached = $image_name;
        }
        if (is_array($request->arrange_country_id)) {
            $string = '';
            $string = implode(",", array_filter($request->arrange_country_id));

            $question->country_id = $string;
        } else {
            $question->country_id = $request->arrange_country_id;
        }
        $question->question_name = htmlentities(str_replace('"', '&quot;', trim($request->arrange_question_input)));
        $question->category_id = $request->arrange_category_id;
        $question->question_type = 3;
        if ($question->save()) {
            $last_insert_id = $question->id;
        }
        foreach ($incorrect_order as $index => $incorrectorder) {
            $answer = new ParentAnswers();
            $answer->question_id = $last_insert_id;
            $answer->options = htmlentities(str_replace('"', '&quot;', trim($incorrectorder)));
            $answer->correct_options = $correct_order[$index];
            if ($answer->save()) {
                
            } else {
                return array('status' => 'error', 'message' => 'Failed to Add Question');
            }
        }
        return array('status' => 'success', 'message' => 'Question successfully saved');
    }

    public static function deleteQuestion($request) {
        try {
            if (ParentAnswers::where('question_id', $request->id)->exists()) {
                ParentAnswers::where('question_id', $request->id)->delete();
            }
            ParentQuestions::where('id', $request->id)->delete($request->id);
             return array('status' => 'success', 'message' => 'Question Deleted Successfully');
            
        } catch (QueryException $ex) {
            return $ex;
        }
    }

}

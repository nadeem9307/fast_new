<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\Questions;
use App\Model\Answers;
use App\Model\Semester;
use App\Model\SubLevels;
use App\Model\Countries;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Response;
use DB;
use Validator;
use Excel;
use App\Helpers\Helper;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\CharsetConverter;

class QuestionController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Show the application Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $categories = new Category();
            $categories = $categories->select('id', 'category_name')->where('status', 1)->get();
            $countries = new Countries();
            $countries = $countries->select('id', 'country_name')->where('status', 1)->get();
            $level = Questions::getlevels();
            $sublevel = Questions::getsublevels();
            $semester = Questions::getsemester();
            return view('admin.questions.index', compact('categories', 'countries', 'level', 'sublevel', 'semester'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get all questions,categories and country data.
     * @params  : none
     * @return  : questions
     */

    public function getAllQuestions(Request $request) {
        try {
            $perpage = $request->datatable['pagination']['perpage'];
            $page = $request->datatable['pagination']['page'];
            $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
            $question_list = (isset($request->datatable['query']['category_id']) && ($request->datatable['query']['category_id'] != "") ? $request->datatable['query']['category_id'] : '');

            if ($page == '1') {
                $offset = 0;
            } else if ($page) {
                $offset = ($page - 1) * $perpage;
            } else {
                $offset = 0;
            }
            $question = Questions::getAllQuestion($perpage, $page, $offset, $draw, $question_list);
            $total = $question->count();
            return Response::json(array('data' => $question));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 8, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question and answer fill in the blank type question data.
     * @params  : none
     * @return  : questions
     */

    public function store_question_fill_blanks(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'fill_attached_file' => 'max:5120',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['fill_attached_file']))
                        $errorMsg = "Please attach a file less than 5 MB" . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $user = Auth::user();
                    $question;
                    $answer;
                    $answers = $request->answer;
                    if ($answers[0] != '') {
                        $ques = Questions::save_question_fill_blanks($request, $answers);
                        if ($ques['status'] == 'success') {
                            return (json_encode(array('status' => 'success', 'message' => 'Question successfully saved')));
                        } else if ($ques['message'] == 'Please select only jpg, png, jpeg images and mp3/mp4 files.') {
                            return json_encode(array('status' => 'error', 'message' => 'Please select only jpg, png, jpeg images and mp3/mp4 files.'));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => 'Failed to Add Question')));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => 'Answer is not filled')));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 7, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question and answer Multi choise type question data.
     * @params  : none
     * @return  : questions
     */

    public function store_question_multi_choice(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'multi_attached_file' => 'max:5120',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['multi_attached_file']))
                        $errorMsg = "Please attach a file less than 5 MB" . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $user = Auth::user();
                    $question;
                    $answer;
                    $options = $request->options[0];
                    $correct_answer = $request->correct_answer[0];
                    $correct_answer = explode(',', $correct_answer);
                    $options = explode('`^`', $options);
                    if ($request->multi_question_input != '') {
                        if ($options != '') {
                            $ques = Questions::save_question_multi_choice($options, $correct_answer, $request);
                            if ($ques['status'] == 'success') {
                                return (json_encode(array('status' => 'success', 'message' => 'Question successfully saved')));
                            } else if ($ques['message'] == 'Please select only jpg, png, jpeg images and mp3/mp4 files.') {
                                return json_encode(array('status' => 'error', 'message' => 'Please select only jpg, png, jpeg images and mp3/mp4 files.'));
                            } else {
                                return (json_encode(array('status' => 'error', 'message' => 'Check correct answer(s)')));
                            }
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => 'Please fill all input box')));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => 'Please fill all input box')));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 7, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save question and answer Arrange order type question data.
     * @params  : none
     * @return  : questions
     */

    public function store_question_arrange_order(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'arrange_attached_file' => 'max:5120',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['arrange_attached_file']))
                        $errorMsg = "Please attach a file less than 5 MB" . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $user = Auth::user();
                    $question;
                    $answer;
                    $incorrect_orders = $request->incorrect_order[0];
                    $correct_orders = $request->correct_order[0];
                    $incorrect_order = explode('`^`', $incorrect_orders);
                    $correct_order = explode('`^`', $correct_orders);
                    if ($request->arrange_question_input != '') {
                        if ($incorrect_order[0] != '') {
                            if ($correct_order[0] != '') {
                                $ques = Questions::save_question_arrange_order($incorrect_order, $correct_order, $request);
                                if ($ques['status'] == 'success') {
                                    return (json_encode(array('status' => 'success', 'message' => 'Question successfully saved')));
                                } else if ($ques['message'] == 'Please select only jpg, png, jpeg images and mp3/mp4 files.') {
                                    return json_encode(array('status' => 'error', 'message' => 'Please select only jpg, png, jpeg images and mp3/mp4 files.'));
                                } else {
                                    return (json_encode(array('status' => 'error', 'message' => 'Failed to Add Question')));
                                }
                            } else {
                                return (json_encode(array('status' => 'error', 'message' => 'Arrange correct order')));
                            }
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => 'Please fill all input box')));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => 'Please fill all input box')));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 7, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit question data.
     * @params  : none
     * @return  : questions
     */

    public function getquestionDetail(Request $request) {
        if ($request->ajax()) {
            try {
                $status = "success";
                //->update(['name' => $request->name])
                $result = Questions::select('questions.*')->where(array('questions.id' => $request->id))->first();
                $result['sem_name'] = Semester::select('id', 'sem_name')->where('sublevel_id', $result->sublevel_id)->get();
                $result['sublevel_name'] = SubLevels::select('id', 'sublevel_name')->get();

                if ($request->id) {
                    $allAnswers = Answers::where(array('question_id' => $request->id))
                            ->get(array(
                        'id',
                        'question_id',
                        'options',
                        'correct_options',
                    ));
                    $corect_ans = Answers::where(array('question_id' => $request->id))
                                    ->get(array(
                                        'id',
                                        'question_id',
                                        'options',
                                        'correct_options',
                                    ))->sortBy('correct_answer', false);
                    $res = array();
                    $answ = array();
                    if (!empty($allAnswers) || !empty($corect_ans)) {
                        foreach ($allAnswers as $ans) {
                            $data = array(
                                'id' => $ans->id,
                                'question_id' => $ans->question_id,
                                'options' => $ans->options,
                                'correct_options' => $ans->correct_options
                            );
                            array_push($res, $data);
                        }
                        foreach ($corect_ans as $ans) {
                            $data = array(
                                'id' => $ans->id,
                                'question_id' => $ans->question_id,
                                'options' => $ans->options,
                                'correct_options' => $ans->correct_options,
                            );
                            array_push($answ, $data);
                        }
                        return (json_encode(array('status' => $status, 'message' => $result, 'answers' => $res, 'correctOrder' => $answ)));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 7, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to delete question data.
     * @params  : none
     * @return  : none
     */

    public function delete(Request $request) {
        if ($request->ajax()) {
            try {
                $status = "success";
                $result = Questions::deleteQuestion($request);
                if ($result['status'] == 'success') {
                    return (json_encode(array('status' => $status, 'message' => 'Question Deleted Successfully')));
                } else {
                    $status = "error";
                    $results = $ex->getMessage();
                    return (json_encode(array('status' => $status, 'message' => $results)));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 30, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to upload bulk questions.
     * @params  : none
     * @return  : none
     */


    /* -------------- insert answer in answer table---------------- */
    /* --------------------this function is used to log question and answer saving if any error -------------- */

    public function questionBulkUpload($id, Request $request) {

        $validator = Validator::make($request->all(), [
                    'upload_country_id' => 'required',
                    'uploadcsv' => 'required',
                    'uploadsublevelid' => 'required',
                    'uploadsemesterid' => 'required',
                    'upload_country_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errorMsg = $validator->getMessageBag()->toArray();
            return (json_encode(array('status' => 'error', 'message' => $errorMsg)));
        } else {
            $upload_country_id = implode(',', $request->upload_country_id);
            $category_data = Questions::where('id', $id)->first();
            if (empty($category_data) || !empty($category_data)) {
                $Data = [];
                if ($request->file('file')->getClientOriginalExtension() != "csv") {
                    return (json_encode(array('status' => 'error', 'message' => "Browse CSV file only")));
                }
                if (Input::hasFile('file')) {
                    try {
                        if ($category_data != '') {
                            $settings = json_encode(['category_id' => $category_data->id, 'country_id' => $upload_country_id]);
                        } else {
                            $settings = json_encode(['category_id' => $id, 'country_id' => $upload_country_id]);
                        }

                        $path = Input::file('file')->getRealPath();
                        $reader = Reader::createFromPath($path, 'r');
                        $reader->setOutputBOM(Reader::BOM_UTF8);
                        $reader->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');
                        $reader->setHeaderOffset(0);
                        $records = (new Statement())->process($reader);
                        $records->getHeader();
//                        $datas = Excel::load($path, function ($reader) {
//                                    
//                                })->get()->toArray();
//
                        $arrayCount = count($records);
//                        $data = array_chunk($datas, 10);
                        if ($arrayCount >= 10) {
                            $arrayCount = 10;
                        }
                        $csv_file = '';

                        $user_type = '3';
                        $csv_file = time() . '.' . $request->file('file')->getClientOriginalExtension();
                        $NewFilePath = $request->file('file')->move(storage_path('app/question_csv'), $csv_file);
                        DB::table('question_file_upload')->insert(['file_name' => $csv_file, 'start_from' => 0, 'end_from' => $arrayCount, 'settings' => $settings, 'user_type' => $user_type, 'uploaded_by' => Auth::id()]);
                        $results = DB::table('question_file_upload')->where('user_type', '3')->where('status', '1')->orderBy('id', 'ASC')->take(1)->first();
//                        print_r($results);
//                        die;
                        $rowline = 1;

//                        foreach ($data as $index => $rows) {
                        foreach ($records as $index => $row) {
//                            echo "<pre>";
//                            print_r($row);

                            if ($row['question_type'] == '1') {
                                if ($row['question_name'] != '' && $row['question_type'] != '' && $row['correct_options'] != '') {
                                    $question_id = $this->insertQuestion($row, $id, $upload_country_id, $rowline, $request, $results->id);
                                    if ($question_id != '') {
                                        $this->saveAnswersByQuestionId($row, $id, $question_id, $rowline, $results->id);
                                    }
                                } else if ($row['question_name'] == '' && $row['question_type'] == '') {
                                    $question_ids = Questions::orderBy('id', 'desc')->first()->toArray();
                                    $question_id = $question_ids['id'];
                                    $this->saveAnswersByQuestionId($row, $question_id, $rowline, $results->id);
                                }
                            } else {
                                if (!empty($row) && $row['question_name'] != '' && $row['question_type'] != '') {
                                    $question_id = $this->insertQuestion($row, $id, $upload_country_id, $rowline, $request, $results->id);
                                    if ($question_id != '') {
                                        $this->saveAnswersByQuestionId($row, $question_id, $rowline, $results->id);
                                    }
                                } else if ($row['question_name'] == '' && $row['question_type'] == '') {
                                    $question_ids = Questions::orderBy('id', 'desc')->first()->toArray();
                                    $question_id = $question_ids['id'];
                                    $this->saveAnswersByQuestionId($row, $question_id, $rowline, $results->id);
                                }
                            }
                            if (!empty($results) && $results != '') {
                                $update = DB::table('question_file_upload')->where('id', $results->id)->update(['last_inserted_question_id' => $question_id, 'start_from' => $index, 'end_from' => $rowline]);
                            }
                            $rowline++;
                        }
//                        die;
//                        }
                        $job_data = ['type' => 1];
                        //(new UploadVouchers($job_data))->dispatch($job_data);
                    } catch (\Illuminate\Database\QueryException $ex) {
                        Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                        return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                    } catch (\Exception $e) {
                        Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                        return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
                    }
                    return (json_encode(array('status' => 'succes', 'message' => "Your file has been uploaded successfully.")));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => "Please upload file.")));
                }
            } else {
                return (json_encode(array('status' => 'error', 'message' => "Category id not exist.")));
            }
        }
    }

    public function insertQuestion($row = array(), $category_id, $country_id, $rowline, $request, $upload_id) {
        try {
            if (!empty($row)) {
                $question = new Questions;
                $question['category_id'] = $category_id;
                $question['country_id'] = $country_id;
                $question['level_id'] = $request->uploadcsv;
                $question['sublevel_id'] = $request->uploadsublevelid;
                $question['semester_id'] = $request->uploadsemesterid;
                $question['question_name'] = htmlentities(str_replace('"', '&quot;', trim($row['question_name'])));
                $question['question_type'] = $row['question_type'];
                $question['user_type'] = '3';
                if ($row['file_attached'] != '') {
                    $file = $row['file_attached'];
                    $contents = file_get_contents($file);
                    $name = substr($file, strrpos($file, '/') + 1);
//                $path = storage_path('app/parent_questions');
                    Storage::put('questions/' . $name, $contents);
                    $question['file_attached'] = $name;
                }

                if ($question->save()) {
                    return $question->id;
                }
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            $this->uploadCsvDataErrorLog($rowline, 1, $ex->getMessage(), $upload_id);
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
        } catch (\Exception $e) {
            $this->uploadCsvDataErrorLog($rowline, 1, $e->getMessage(), $upload_id);
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
        }
        return false;
    }

    /* -------------- insert answer by question id ---------------- */

    public function saveAnswersByQuestionId($row = array(), $question_id, $rowline, $upload_id) {
        try {
            $question = Questions::find($question_id);
            $answer = new Answers();
            $options = htmlentities(str_replace('"', '&quot;', trim($row['options'])));
            $correct_options = htmlentities(str_replace('"', '&quot;', trim($row['correct_options'])));
            if (($question) && (!empty($row))) {
                if ($question->question_type == 1 && $correct_options != '') {
                    $answer->question_id = $question_id;
                    $answer->options = (isset($options) ? $options : '');
                    $answer->correct_options = $correct_options;
                } else if (($question->question_type == 2 || $question->question_type == 3)) {
                    if ($row['options'] != '') {
                        $answer->question_id = $question_id;
                        $answer->options = $options;
                        $answer->correct_options = $correct_options;
                    } else {
                        $this->uploadCsvDataErrorLog($rowline, 2, 'Correct option or option not found', $upload_id);
                    }
                }
                if ($answer->save()) {
                    return true;
                } else {
                    return false;
                }
            }
            $this->uploadCsvDataErrorLog($rowline, 2, 'Question id not found.', $upload_id);
        } catch (\Illuminate\Database\QueryException $ex) {
            $this->uploadCsvDataErrorLog($rowline, 2, $ex->getMessage(), $upload_id);
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
        } catch (\Exception $e) {
            $this->uploadCsvDataErrorLog($rowline, 2, $e->getMessage(), $upload_id);
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
        }
        return false;
    }

    /* --------------------this function is used to log question and answer saving if any error -------------- */

    public function uploadCsvDataErrorLog($rowline, $error_type, $error_msg, $upload_id) {
        try {
            DB::table('upload_reports')->insert(['uploaded_id' => $upload_id, 'error_type' => $error_type, 'row_line' => $rowline, 'error' => $error_msg]);
        } catch (\Illuminate\Database\QueryException $ex) {
            $this->uploadCsvDataErrorLog($rowline, 2, $ex->getMessage(), $upload_id);
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
        } catch (\Exception $e) {
            $this->uploadCsvDataErrorLog($rowline, 2, $e->getMessage(), $upload_id);
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
        }
    }

    /*
     * @created : Feb 18, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get Sublevels.
     * @params  : none
     * @return  : none
     */

    public function getLevel(Request $request) {
        if ($request->ajax()) {
            try {
                $sublevel['sublevel'] = DB::table('sublevels')->orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
                $sublevel['category'] = Category::where('level_id', $request->id)->where('status', 1)->get()->toArray();
                if ($sublevel) {
                    return (json_encode(array('status' => 'success', 'data' => $sublevel)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => "Please select level")));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Feb 18, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get Semester.
     * @params  : none
     * @return  : none
     */

    public function getSubLevel(Request $request) {
        if ($request->ajax()) {
            try {
                //              $semester = Semester::where('level_id', $request->level_id)->where('sublevel_id', $request->sublevel_id)->where('status', 1)->get()->toArray();
                $semester = Semester::where('sublevel_id', $request->sublevel_id)->where('status', 1)->get()->toArray();
                if ($semester) {
                    return (json_encode(array('status' => 'success', 'data' => $semester)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => "Please select level")));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

}

<?php
namespace App\Http\Controllers\Admin\Parent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ParentOverAllInterpretation;
use App\Model\OverAllRange;
use Validator;
use App\Helpers\Helper;
use Exception;

class OverallInterpretationController extends Controller
{
    /*
     * @created : Jan 24, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to return view of  Overall Interpretation Data.
     * @params  : 4
     * @return  : view
     */

    public function index()
    {

        $rangeid = "";
        $data = ParentOverAllInterpretation::GetInterpretationRange($rangeid);
        $combos = $this->generate_combinations($data);
        return view('admin.parent.overall_interpretation.set_interpretation');
    }

    /*
     * @created : Jan 27, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save overall interpretattion
     * @params  : None
     * @return  : None
     */

    public function OverAllInterpretation(request $request)
    {
        if ($request->ajax()) {
             $rules = array(
                'range_id' => 'required',
                'category_id' => 'required',
                'overall_range' => 'required',
                'interpretation' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['category_id']))
                    $errorMsg = $failedRules['category_id'][0] . "\n";
                if (isset($failedRules['interpretation']))
                    $errorMsg = $failedRules['interpretation'][0] . "\n";
                if (isset($failedRules['range_id']))
                    $errorMsg = $failedRules['range)id'][0] . "\n";
                if (isset($failedRules['overall_range']))
                    $errorMsg = $failedRules['overall_range'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end  validation ------------------- */
            } else {
                try {
                    $interpretation = ParentOverAllInterpretation::SaveOverAllInterpretation($request);
                    if ($interpretation === false) {
                        return (json_encode(array('status' => 'error', 'message' => "Attempting dupicate interpretation for same range.")));
                    } else {
                        return (json_encode(array('status' => 'success', 'message' => 'Interpretation data successfully saved.')));
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    $error_code = $ex->errorInfo[1];
                    if ($error_code == 1062) {
                        return (json_encode(array('status' => 'error', 'message' => 'Failed to save interpretation.')));
                    } else {
                        Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                        return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                    }
                } catch (\Exception $e) {
                    Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                    return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
                }
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to delete interpretation details.
     * @params  : none
     * @return  : delete interpretation
     */

    public function getOverallRange(Request $request)
    {
//          $interpretations = array(
//                "1"=>"Score reflects poor knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart buying and investing, managing debt. Poor understanding of financial concepts. Unable to analyse financial situations and options accurately. Highly influenced by peers while making financial decisions, likes to conform to the trend. Is unable to apply knowledge to real life situations. Does not display possession of good and sound money habits and attitude.",
//                "2"=>"Score reflects a less than acceptable knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart buying and investing, managing debt.  Average understanding of financial concepts. Somewhat able to analyse financial situations and options accurately. Somewhat influenced by peers while making financial decisions, likes to conform to the trend. Able to apply few concepts and knowledge to real life situations. Displays possession of a few good and sound money habits and attitude.",
//                "3"=>"Score reflects an acceptable knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart buying and investing, managing debt. Good understanding of financial concepts. Able to analyse financial situations and options accurately. Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend. Able to apply most financial concepts and knowledge to real life situations. Displays possession of good and sound money habits and attitude.",
//                "4"=>"Score reflects very good knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart buying and investing, managing debt. Very Good understanding of financial concepts. Able to critically analyse financial situations and options accurately. Is financially savvy and able to take financial decisions without being influenced by peers, based on his or her own financial goals and circumstances. Able to apply most financial concepts and knowledge to real life situations. Displays possession of many good and sound money habits and attitude.",
//                "5"=>"Score reflects superlative knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart buying and investing, managing debt. Excellent understanding of financial concepts. Able to critically analyse financial situations and options and understand and explain their implications accurately. Is financially savvy and able to take financial decisions independently, is able to advise and influence peers to take the right decisions to achieve financial freedom. Able to apply all financial concepts and knowledge to real life situations. Displays possession of excellent money habits and attitude.",
//                );
        $overall_range = (explode("-", $request->ranges));
        $o_range = $request->ranges;
        $range = OverAllRange::find($request->id);
        if ($range) {
            $data = ParentOverAllInterpretation::GetInterpretationRange($range->id);
            $cats = $data['categories'];
            $overall_ids = $data['overall_ids'];
            $range_id = $range->id;
            $i = 0;
            foreach ($data['categories'] as $index => $id) {
                $combos_groups[$index] = $data['ranges'];
                $i++;
            }
           $comboss = $this->generate_combinations($combos_groups);
            $combos = array_filter($comboss, function($v, $k) use($i, $range) {//$interpretations
                $cur_min = (array_sum(array_column($v, 'min_range')) / $i);
                $cur_max = (array_sum(array_column($v, 'max_range')) / $i);
//                 if (!empty(array_intersect(range(ceil($cur_min), ceil($cur_max)), range(ceil($range->min_range), ceil($range->max_range - 1))))) {
//                        $interp = new ParentOverAllInterpretation();
//                        $interp->category_ids = '1,2,3';
//                        $interp->individual_range_ids = implode(",",array_column($v,'id'));
//                        $interp->overall_range = $range->id;
//                        $interp->interpretation = json_encode(array($interpretations[$range->id]));
//                        $interp->save();
//                    }
                return !empty(array_intersect(range(ceil($cur_min),ceil($cur_max)),range(ceil($range->min_range),ceil($range->max_range-1))));
                //return ((($cur_min>=$range->min_range)&&($cur_min<$range->max_range))||(($cur_max>=$range->min_range)&&($cur_max<$range->max_range)) || ());
            }, ARRAY_FILTER_USE_BOTH);
            return view('admin.parent.overall_interpretation.overall_interpretation', compact('combos', 'cats', 'overall_ids', 'range_id'));
        } else {
            abort(404);
        }
    }

    function generate_combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
    {
        $keys = array_keys($data);
        if (isset($value) === true) {
            array_push($group, $value);
        }
        if ($i >= count($data)) {
            array_push($all, $group);
        } else {
            $currentKey = $keys[$i];
            $currentElement = $data[$currentKey];
            foreach ($currentElement as $val) {
                $this->generate_combinations($data, $all, $group, $val, $i + 1);
            }
        }
        return $all;
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit interpretation details.
     * @params  : none
     * @return  : updated interpretation
     */

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $overall = ParentOverAllInterpretation::EditOverallInterpretation($request);
                if ($overall !== false) {
                    return (json_encode(array('status' => $status, 'message' => $overall)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => 'No Data Found')));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                $status = "error";
                return (json_encode(array('status' => $status, 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }
}

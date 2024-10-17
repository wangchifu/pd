<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolAssign;

class ReviewController extends Controller
{
    public function index(){  
        $reports = Report::orderBy('id','DESC')->paginate(4);

        $reviewers = User::where('review',1)->get();

        
        $data = [
            'reports'=>$reports,
            'reviewers'=>$reviewers,
        ];

        return view('reviews.index',$data);
    }

    public function school_assign(Request $request,Report $report){
        //查是否已經有勾選過了
        $school_assign = SchoolAssign::where('report_id',$report->id)->where('user_id',$request->input('reviewer_id'))->first();    
        $select_schools = (!empty($school_assign->id))?unserialize($school_assign->schools_array):[];     
        
        //查其他人的勾選
        $other_school_assigns = SchoolAssign::where('report_id',$report->id)->where('user_id','<>',$request->input('reviewer_id'))->get();    
        foreach($other_school_assigns as $other_school_assign){
            $other_select_schools = unserialize($other_school_assign->schools_array);
            foreach($other_select_schools as $k=>$v){
                $other_select_school_data[$v] = $other_school_assign->user->name;
            }
        }
        

        $township_ids = config('pd.township_ids');
        $schools = School::all();
        foreach($schools as $school){
            $school_array[$school->township_id][$school->code] = $school->name;
            if(!isset($school_fill[$school->code])) $school_fill[$school->code] = 0;            
        }

        $reviewer = User::find($request->input('reviewer_id'));
        $data = [
            'select_schools'=>$select_schools,
            'other_select_school_data'=>$other_select_school_data,
            'report'=>$report,
            'reviewer'=>$reviewer,
            'township_ids'=>$township_ids,
            'school_array'=>$school_array,
        ];

        return view('reviews.school_assign',$data);
    }

    public function do_school_assign(Request $request){
        $att= $request->all();
        dd($att);
        $att['schools_array'] = serialize($att['select_school']);

        //查是否已經有勾選過了
        $school_assign = SchoolAssign::where('report_id',$request->input('report_id'))->where('user_id',$request->input('user_id'))->first();    
        if(!empty($school_assign->id)){
            $school_assign->update($att);
        }else{
            SchoolAssign::create($att);
        }        
        return redirect()->route('review.index');


    }

    public function check_reviewer($report_id,$reviewer_id){
        $school_assign = SchoolAssign::where('report_id',$report_id)->where('user_id',$reviewer_id)->first();        
        $select_schools = (!empty($school_assign->id))?unserialize($school_assign->schools_array):[];
        
        $schools_name = config('pd.schools_name');
        $result = (empty($school_assign->id))?"尚未指定學校":"";
        
        $n=0;
        foreach($select_schools as $k=>$v){
           $result .= $schools_name[$v].",";
           $n++;
        }
        if($result != "尚未指定學校") $result.="(共 ".$n." 校)";
        echo json_encode($result);
        return;
    }
}

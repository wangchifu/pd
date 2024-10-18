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
        $request->validate([
            'name' => 'required',
        ]);
        //查是否已經有勾選過了
        $school_assign = SchoolAssign::where('report_id',$report->id)->where('name',$request->input('name'))->first();    
        $select_schools = (!empty($school_assign->id))?unserialize($school_assign->schools_array):[];     
        
        //查其他人的勾選
        $other_school_assigns = SchoolAssign::where('report_id',$report->id)->where('name','<>',$request->input('name'))->get();    
        $other_select_school_data1 = [];
        $other_select_school_data2 = [];
        foreach($other_school_assigns as $other_school_assign){
            $other_select_schools = unserialize($other_school_assign->schools_array);
            foreach($other_select_schools as $k=>$v){
                $other_select_school_data1[$v] = $other_school_assign->user->name;
                $other_select_school_data2[$v] = $other_school_assign->name;
            }
        }        

        $township_ids = config('pd.township_ids');
        $schools = School::all();
        foreach($schools as $school){
            $school_array[$school->township_id][$school->code] = $school->name;
            if(!isset($school_fill[$school->code])) $school_fill[$school->code] = 0;            
        }

        $reviewers = User::where('review','1')->get();
        $data = [
            'school_assign'=>$school_assign,
            'select_schools'=>$select_schools,
            'other_select_school_data1'=>$other_select_school_data1,
            'other_select_school_data2'=>$other_select_school_data2,
            'report'=>$report,
            'reviewers'=>$reviewers,
            'township_ids'=>$township_ids,
            'school_array'=>$school_array,
            'name'=>$request->input('name'),
        ];

        return view('reviews.school_assign',$data);
    }

    public function do_school_assign(Request $request){
        $att= $request->all();
        
        $att['schools_array'] = serialize($att['select_school']);

        //查是否已經有勾選過了
        $school_assign = SchoolAssign::where('report_id',$request->input('report_id'))->where('name',$request->input('name'))->first();    
        if(!empty($school_assign->id)){
            $school_assign->update($att);
        }else{
            SchoolAssign::create($att);
        }        
        return redirect()->route('review.index');


    }

    public function check_group($report_id,$name){
        $school_assign = SchoolAssign::where('report_id',$report_id)->where('name',$name)->first();        
        $select_schools = (!empty($school_assign->id))?unserialize($school_assign->schools_array):[];
        
        $schools_name = config('pd.schools_name');
        if(empty($school_assign->id)){
            $result = "尚未指定評審及學校";            
        }else{
            $result = "評審：".$school_assign->user->name."<br>";                        
        };
        
        $n=0;
        foreach($select_schools as $k=>$v){
           $result .= $schools_name[$v].",";
           $n++;
        }
        if($result != "尚未指定評審及學校") $result.="(共 ".$n." 校)";
        echo json_encode($result);
        return;
    }
}

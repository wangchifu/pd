<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolAssign;
use App\Models\Opinion;
use App\Models\Score;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

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

    public function score(){
        $reports = Report::orderBy('id','DESC')->paginate(4);
        $reviewers_array = [];
        foreach($reports as $report){
            $school_assigns = SchoolAssign::where('report_id',$report->id)->get();
            foreach($school_assigns as $school_assign){
                $reviewers_array[$report->id][$school_assign->name] = $school_assign->user->name;
            }
        }
        

        $data = [
            'reports'=>$reports,
            'reviewers_array'=>$reviewers_array,
        ];

        return view('reviews.score',$data);
    }

    public function import(Report $report){
        $data = [
            'report'=>$report,            
        ];

        return view('reviews.import',$data);
    }

    public function do_import(Request $request){
        $request->validate([
            'file' => 'required',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');            
            $collection = (new FastExcel)->import($file);            
            foreach ($collection as $row) {
                $school = School::where('code','like','%'.$row['代碼'].'%')->first();
                $att['school_name'] = $school->name;
                $att['school_code'] = $school->code;
                $att['suggestion'] = $row['綜合意見'];
                $att['report_id'] = $request->input('report_id');
                $att['user_id'] = $request->input('user_id');
                
                $check = Opinion::where('school_code',$att['school_code'])->where('report_id',$att['report_id'])->first();
                if(!empty($check->id)){
                    $check->update($att);
                }else{
                    Opinion::create($att);
                }
            }
            
            echo "<body onload=\"opener.location.reload();;window.close();\">";

        }
    }

    public function award(Request $request){
        $att = $request->all();
        $report = Report::find($att['report_id']);
        $school_assign = SchoolAssign::where('report_id',$att['report_id'])->where('name',$att['name'])->first();
        $schools_array = [];
        $score_data = [];
        $suggestion = [];
        if(!empty($school_assign->id)){
            $schools_array = unserialize($school_assign->schools_array);
            foreach($schools_array as $k=>$v){
                $scores = Score::where('report_id',$att['report_id'])->where('school_code',$v)->get();
                foreach($scores as $score){
                    $score_data[$v][$score->comment_id] = $score->score;                    
                }
                $opinion = Opinion::where('school_code',$v)->where('report_id',$report->id)->first();
                $suggestion[$v] = (!empty($opinion->suggestion))?$opinion->suggestion:"";
            }
        }
        
        foreach($schools_array as $k=>$v){
            $total_score[$v] = 0;
            foreach($report->comments as $comment){
                if(isset($score_data[$v][$comment->id])) $total_score[$v] += $score_data[$v][$comment->id];
            }
        }
        krsort($total_score);
        //dd($total_score);

        $data = [
            'group_name'=>$att['name'],
            'schools_name'=>config('pd.schools_name'),
            'report'=>$report,
            'schools_array'=>$schools_array,
            'score_data'=>$score_data,
            'suggestion'=>$suggestion,
            'total_score'=>$total_score,
        ];

        return view('reviews.award',$data);
    }
}


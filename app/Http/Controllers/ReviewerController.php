<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolAssign;
use App\Models\Opinion;
use App\Models\Score;

class ReviewerController extends Controller
{
    public function index(){  
        $reports = Report::orderBy('id','DESC')->paginate(4);
        $school_assigns = SchoolAssign::where('user_id',auth()->user()->id)->get();
        $assign_schools = [];
        foreach($school_assigns as $school_assign){
            $assign_schools[$school_assign->report_id] = unserialize($school_assign->schools_array);
        }        
        $schools_name = config('pd.schools_name');
        $data = [           
            'reports' =>$reports,
            'assign_schools'=>$assign_schools,
            'schools_name'=>$schools_name,
        ];

        return view('reviewers.index',$data);
    }

    public function school(Report $report,$school_code){
        $schools_name = config('pd.schools_name');
        $upload_data = [];
        foreach($report->uploads as $upload){
            $upload_data[$upload->id] = $upload->title;
        }

        //查是否已經有輸入過了 
        $opinion = Opinion::where('report_id',$report->id)->where('school_code',$school_code)->first();
        $suggestion = (!empty($opinion->id))?$opinion->suggestion:null;
        $scores = Score::where('report_id',$report->id)->where('school_code',$school_code)->get();
        $score_data = [];
        foreach($scores as $score){
            $score_data[$score->comment_id] = $score->score;
        }
        
        $data = [           
            'report' =>$report,            
            'schools_name'=>$schools_name, 
            'school_code'=>$school_code,
            'upload_data'=>$upload_data,
            'suggestion'=>$suggestion,
            'score_data'=>$score_data,

        ];

        return view('reviewers.school',$data);
    }

    public function school_store(Request $request){
        $att = $request->all();
        foreach($att['score_array'] as $k=>$v){
            $att['comment_id'] = $k;
            $att['score'] = $v;     
            $check = Score::where('comment_id',$att['comment_id'])->where('school_code',$att['school_code'])->first();
            if(!empty($check->id)){
                $check->update($att);
            }else{
                Score::create($att);
            }
            
        }

        $check = Opinion::where('report_id',$att['report_id'])->where('school_code',$att['school_code'])->first();
        if(!empty($check->id)){
            $check->update($att);
        }else{
            Opinion::create($att);
        }        

        return redirect()->route('reviewer.index');
    }
    
}

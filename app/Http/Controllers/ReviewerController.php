<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolAssign;
use App\Models\Opinion;
use App\Models\Score;
use App\Models\Comment;

class ReviewerController extends Controller
{
    public function index(){  
        $reports = Report::orderBy('id','DESC')->paginate(4);
        $school_assigns = SchoolAssign::where('user_id',auth()->user()->id)->get();
        $assign_schools = [];
        $group_name = [];
        foreach($school_assigns as $school_assign){
            $assign_schools[$school_assign->report_id] = unserialize($school_assign->schools_array);
            $group_name[$school_assign->report_id] = $school_assign->name;
        }        
        $schools_name = config('pd.schools_name');
        $data = [           
            'reports' =>$reports,
            'group_name'=>$group_name,
            'assign_schools'=>$assign_schools,
            'schools_name'=>$schools_name,
        ];

        return view('reviewers.index',$data);
    }

    public function group(Report $report,$name){        
        $school_assign = SchoolAssign::where('user_id',auth()->user()->id)  
            ->where('report_id',$report->id)      
            ->where('name',$name)->first();     
        if(empty($school_assign->id)){
            return back();
        }else{                        
            if($school_assign->user_id != auth()->user()->id){                
                return back();
            }
        }
        
        $schools_array = [];
        $score_data = [];
        $suggestion = [];
        $grade = [];
        if(!empty($school_assign->id)){
            $schools_array = unserialize($school_assign->schools_array);
            foreach($schools_array as $k=>$v){
                $scores = Score::where('report_id',$report->id)->where('school_code',$v)->get();
                foreach($scores as $score){
                    $score_data[$v][$score->comment_id] = $score->score;                    
                }
                $opinion = Opinion::where('school_code',$v)->where('report_id',$report->id)->first();
                $suggestion[$v] = (!empty($opinion->suggestion))?$opinion->suggestion:"";
                $grade[$v] = (!empty($opinion->grade))?$opinion->grade:"";
            }
        }        
        $total_score = [];
        foreach($schools_array as $k=>$v){
            $total_score[$v] = 0;
            foreach($report->comments as $comment){
                if(isset($score_data[$v][$comment->id])) $total_score[$v] += $score_data[$v][$comment->id];
            }
        }
        arsort($total_score);
        

        $data = [
            'group_name'=>$name,
            'schools_name'=>config('pd.schools_name'),
            'report'=>$report,
            'schools_array'=>$schools_array,
            'score_data'=>$score_data,
            'suggestion'=>$suggestion,
            'grade'=>$grade,
            'total_score'=>$total_score,
        ];

        return view('reviewers.group',$data);
    }

    public function reward(Report $report,$school_code,$grade){     
        $schools_name = config('pd.schools_name');         
        $att['grade'] = $grade;
        $opinion = Opinion::where('report_id',$report->id)
            ->where('school_code',$school_code)->first();
        if(!empty($opinion->id)){
            $opinion->update($att);
        }else{
            $att['school_name'] = $schools_name[$school_code];
            $att['school_code'] = $school_code;
            $att['report_id'] = $report->id;
            $att['user_id'] = auth()->user()->id;            
            Opinion::create($att);
        }
    
        return back();
        
    }

    public function reward_remove(Report $report,$school_code){     
        $schools_name = config('pd.schools_name');         
        $att['grade'] = null;
        $opinion = Opinion::where('report_id',$report->id)
            ->where('school_code',$school_code)->first();
        $opinion->update($att);
    
        return back();
        
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

    public function open_file(Report $report,$school_name,$file_name){
        $file = storage_path('app/privacy/fills/'.$report->id.'/'. $school_name .'/'. $file_name);
        return response()->file($file);
    }

    public function school_store(Request $request){
        $request->validate([
            'score_array' => 'required',
            'suggestion' => 'required',
        ]);
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

    public function school_store_one(Request $request){
        $att['comment_id'] = $request->input('value1');
        $att['school_name'] = $request->input('value2');        
        $att['score'] = $request->input('value3');
        $att['user_id'] = auth()->user()->id;

        $school = School::where('name',$att['school_name'])->first();
        $att['school_code'] = $school->code;
        $comment = Comment::find($att['comment_id']);
        $att['report_id'] = $comment->report_id;

        
        $check = Score::where('comment_id',$att['comment_id'])->where('school_name',$att['school_name'])->first();
        if(!empty($check->id)){
            $check->update($att);
        }else{
            Score::create($att);
        }             
        $result = "已登錄 ".$att['score']." 分";
        echo json_encode($result);
        return;
    }
    
}

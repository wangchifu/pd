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

        $reviewers = User::where('review',1)->where('disable',null)->get();

        
        $data = [
            'reports'=>$reports,
            'reviewers'=>$reviewers,
        ];

        return view('reviews.index',$data);
    }

    public function school_assign(Request $request,Report $report){
        $att = $request->all();        
        $school_assign = SchoolAssign::where('report_id',$report->id)->where('name',$request->input('name'))->first();            
        if($att['action']=="為評審"){
            if(!empty($school_assign->id)){
                $school_assign->update($att);
            }else{
                SchoolAssign::create($att);
            }
            return back();
        }
        if($att['action']=="指定學校"){
            //查是否已經有勾選過了
            if(empty($school_assign->id)){
                $select_schools = [];
            }else{
                if(empty($school_assign->schools_array)){
                    $select_schools = [];
                }else{
                    $select_schools = unserialize($school_assign->schools_array);
                }
            } 

            //$select_schools = (!empty($school_assign->id))?unserialize($school_assign->schools_array):[];     
            
            //查其他人的勾選
            $other_school_assigns = SchoolAssign::where('report_id',$report->id)
                ->where('name','<>',$request->input('name'))
                ->where('schools_array','<>',null)
                ->get();    
            $other_select_school_data1 = [];
            $other_select_school_data2 = [];            
            foreach($other_school_assigns as $other_school_assign){
                $other_select_schools = unserialize($other_school_assign->schools_array);
                foreach($other_select_schools as $k=>$v){
                    if($other_school_assign->user_id){
                        $other_select_school_data1[$v] = $other_school_assign->user->name;
                    }else{
                        $other_select_school_data1[$v] = "未指定";
                    }
                    
                    $other_select_school_data2[$v] = $other_school_assign->name;
                }
            }        

            $township_ids = config('pd.township_ids');
            $schools = School::all();
            foreach($schools as $school){
                $school_array[$school->township_id][$school->code] = $school->name;
                if(!isset($school_fill[$school->code])) $school_fill[$school->code] = 0;            
            }

            //$reviewers = User::where('review','1')->get();
            $data = [
                'school_assign'=>$school_assign,
                'select_schools'=>$select_schools,
                'other_select_school_data1'=>$other_select_school_data1,
                'other_select_school_data2'=>$other_select_school_data2,
                'report'=>$report,
                //'reviewers'=>$reviewers,
                'township_ids'=>$township_ids,
                'school_array'=>$school_array,
                'name'=>$request->input('name'),
            ];

            return view('reviews.school_assign',$data);
        }
        
    }

    public function school_assign_copy($old_id=null,$new_id=null){
        
        if(empty($old_id)){
            return back()->withErrors(['error' => ['id 為必填']]);
        }
        $old_report = Report::find($old_id);
        if(empty($old_report->id)){
            return back()->withErrors(['error' => ['沒有此 id']]);
        }

        if($old_id == $new_id){
            return back()->withErrors(['error' => ['自己的 id 是要怎樣複製到自己？']]);
        }
        $school_assigns = SchoolAssign::where('report_id',$old_id)->get();
        SchoolAssign::where('report_id',$new_id)->delete();
        foreach($school_assigns as $school_assign){
            $att['name'] = $school_assign->name;
            $att['report_id'] = $new_id;
            $att['user_id'] = $school_assign->user_id;
            $att['schools_array'] = $school_assign->schools_array;

            SchoolAssign::create($att);
        }

        return back();
    }

    public function do_school_assign(Request $request){        
        $att= $request->all();
        if(!isset($att['select_school'])){
            return back()->withErrors(['error' => ['沒有選擇學校！']]);
        }
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
        if(empty($school_assign->id)){
            $select_schools = [];
        }else{
            if(empty($school_assign->schools_array)){
                $select_schools = [];
            }else{
                $select_schools = unserialize($school_assign->schools_array);
            }
        }        
        
        $result = $name."<br>";
        $schools_name = config('pd.schools_name');
        if(empty($school_assign->id)){
            $result .= "尚未指定評審及學校";            
        }else{
            if(!empty($school_assign->user_id)){
                $result .= "評審：".$school_assign->user->name."<br>";                        
            }else{
                $result .= "評審：未指定<br>";                        
            }
            
        };

        $n=0;
        foreach($select_schools as $k=>$v){
           $result .= $schools_name[$v].",";
           $n++;
        }
        if(!strpos($result,"尚未指定評審及學校")) $result.="(共 ".$n." 校)";
        echo json_encode($result);
        return;
    }

    public function score(){
        $reports = Report::orderBy('id','DESC')->paginate(4);
        $reviewers_array = [];
        foreach($reports as $report){
            $school_assigns = SchoolAssign::where('report_id',$report->id)->get();
            foreach($school_assigns as $school_assign){
                if(!empty($school_assign->name) and !empty($school_assign->user_id)){
                    $reviewers_array[$report->id][$school_assign->name] = $school_assign->user->name;
                }               
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

    public function download(Report $report){
        $exec = "cd ".storage_path('app/public/fills')." && zip -r ./{$report->title}.zip ./".$report->id;        
        shell_exec($exec);
            
        $zipFileName = storage_path('app/public/fills/'.$report->title.'.zip');
        //dd($zipFileName);
        // 設置 HTTP 標頭以便下載 ZIP 檔案
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
        header('Content-Length: ' . filesize($zipFileName));
        // 清空輸出緩衝區
        ob_clean();
        flush();

        // 讀取 ZIP 檔案並輸出到瀏覽器
        readfile($zipFileName);

        // 刪除本地生成的 ZIP 檔案
        unlink($zipFileName);                
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
        $total_score = [];
        foreach($schools_array as $k=>$v){
            $total_score[$v] = 0;
            foreach($report->comments as $comment){
                if(isset($score_data[$v][$comment->id])) $total_score[$v] += $score_data[$v][$comment->id];
            }
        }
        arsort($total_score);
        

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


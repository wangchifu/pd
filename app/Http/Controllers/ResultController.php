<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\School;
use App\Models\Fill;
use App\Models\Upload;

class ResultController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','DESC')->get();
        
        $schools = School::all();
        $upload_count = [];
        $school_has_finish = [];
        foreach($reports as $report){            
            //題目數            
            $upload_count[$report->id] = Upload::where('report_id',$report->id)->count();            

            $fills = Fill::where('report_id',$report->id)->get();
            $school_fill = [];            
            foreach($fills as $fill){                
                if(!isset($school_fill[$report->id][$fill->school_code])) $school_fill[$report->id][$fill->school_code] = 0;
                $school_fill[$report->id][$fill->school_code]++;
            }
            
            //dd($school_fill);
            foreach($schools as $school){                                                                                
                if(!isset($school_fill[$report->id][$school->code])) $school_fill[$report->id][$school->code] = 0;            
            }            

            //算已填
            if(!isset($school_has_finish[$report->id])) $school_has_finish[$report->id] = 0;   
            foreach($school_fill as $k => $v){
                foreach($v as $k1=>$v1){
                    if($v1 == $upload_count[$report->id]) $school_has_finish[$report->id]++;
                }                
            }
        }
        
        //應填
        $schools_num = School::count();        

        $data = [
            'reports'=>$reports,
            'upload_count'=>$upload_count,
            'schools_num'=>$schools_num,
            'school_has_finish'=>$school_has_finish,
        ];
        return view('results.index',$data);
    }

    public function view(Report $report){
        if(date('Y-m-d') <= $report->stop_date){
            if(!auth()->check()){
                return back()->withErrors(['errors' => ['此成果尚不能公開取閱！']]);     
            }else{
                if(auth()->user()->admin != 1){
                    return back()->withErrors(['errors' => ['此成果尚不能公開取閱！']]);     
                }
            }            
        }
        $township_ids = config('pd.township_ids');
        $schools = School::all();

        $fills = Fill::where('report_id',$report->id)->get();
        $school_fill = [];
        foreach($fills as $fill){
            if(!isset($school_fill[$fill->school_code])) $school_fill[$fill->school_code] = 0;
            $school_fill[$fill->school_code]++;
        }

        foreach($schools as $school){
            $school_array[$school->township_id][$school->code] = $school->name;
            if(!isset($school_fill[$school->code])) $school_fill[$school->code] = 0;            
        }
        $data = [
            'report'=>$report,
            'township_ids'=>$township_ids,
            'school_array'=>$school_array,
            'school_fill'=>$school_fill,
        ];
        return view('results.view',$data);
    }

    public function nonesent(Report $report){
            
            $upload_count = Upload::where('report_id',$report->id)->count();

            $fills = Fill::where('report_id',$report->id)->get();
            $school_fill = [];            
            foreach($fills as $fill){                
                if(!isset($school_fill[$fill->school_code])) $school_fill[$fill->school_code] = 0;
                $school_fill[$fill->school_code]++;
            }
            $schools = School::all();

            foreach($schools as $school){                                                                                
                if(!isset($school_fill[$school->code])) $school_fill[$school->code] = 0;            
            }            

            
        $data = [
            'upload_count'=>$upload_count,
            'school_fill'=>$school_fill,
            'schools'=>$schools,
        ];
        return view('results.nonesent',$data);
    }

    function show(Report $report,$code){
        if(date('Y-m-d') <= $report->stop_date){
            if(!auth()->check()){
                return back()->withErrors(['errors' => ['此成果尚不能公開取閱！']]);     
            }else{
                if(auth()->user()->admin != 1){
                    return back()->withErrors(['errors' => ['此成果尚不能公開取閱！']]);     
                }
            }            
        }
            $fills = Fill::where('report_id',$report->id)
                ->where('school_code',$code)
                ->get();
                
            $fill_data = [];
            if(empty($fills->first())){
                return redirect()->route('index');
            }else{
                foreach($fills as $fill){
                    $fill_data[$fill->upload_id] = $fill->filename;
                }
            }
            $schools_name = config('pd.schools_name');
        $data = [
            'report'=>$report,
            'code'=>$code,
            'fill_data'=>$fill_data,
            'school_name'=>$schools_name[$code],
            'code'=>$code,
        ];
        return view('results.show',$data);
    }

    public function open_file(Report $report,$school_name,$file_name){
        $schools_name = config('pd.schools_name');
        if(auth()->user()->admin != 1){
            if($schools_name[auth()->user()->school_code] != $school_name){
                return back();
            }
        }
        $file = storage_path('app/privacy/fills/'.$report->id.'/'. $school_name .'/'. $file_name);
        return response()->file($file);
    }
    
}

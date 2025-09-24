<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fill;
use App\Models\Report;
use App\Models\Upload;
use App\Models\School;
use App\Models\Opinion;
use App\Models\Score;
use Illuminate\Support\Str;

class FillController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','DESC')->get();        
        $school = School::where('code','like','%'.auth()->user()->school_code.'%')->first();
        $data = [
            'reports'=>$reports,            
            'school'=>$school,
        ];
        return view('fills.index',$data);
    }

    public function award(Report $report){
        $opinion = Opinion::where('report_id',$report->id)->where('school_code','like','%'.auth()->user()->school_code.'%')->first();
        
        //還沒有公開不能看
        if(!empty($opinion->id)){
            if($opinion->open != 1){
                return back();    
            }
        }else{
            return back();
        }


        $school = School::where('code','like','%'.auth()->user()->school_code.'%')->first();
        $scores = Score::where('report_id',$report->id)->where('school_code','like','%'.auth()->user()->school_code.'%')->get();
        $score_data = [];
        foreach($scores as $score){
            $score_data[$score->comment_id] = $score->score;
        }

        $upload_data = [];
        foreach($report->uploads as $upload){
            $upload_data[$upload->id] = $upload->title;
        }

        $fills = Fill::where('report_id',$report->id)
        ->where('school_code',$school->code)
        ->get();
        
        $fill_data = [];
        foreach($fills as $fill){
            $fill_data[$fill->upload_id] = $fill->filename;
        }


        $data = [
            'school'=>$school,
            'report'=>$report,
            'opinion'=>$opinion,    
            'score_data'=>$score_data,
            'upload_data'=>$upload_data,
            'fill_data'=>$fill_data,
        ];
        return view('fills.award',$data);

    }

    public function create(Report $report){
        if ($report->start_date > date('Y-m-d') or $report->stop_date < date('Y-m-d')) {
            return back()->withErrors(['error' => ['現在不是填報日期！']]);
        }
        $school = School::where('code','like','%'.auth()->user()->school_code.'%')->first();
        $data = [
            'school'=>$school,
            'report'=>$report,
        ];
        return view('fills.create',$data);
    }

    public function store(Request $request,Upload $upload){
        
        $school_code = get_schoool_code(auth()->user()->school_code);            
        $school_name_array = config('pd.schools_name');        
        $school_name = $school_name_array[$school_code];
        
        if($upload->type=="pdf" or $upload->type=="mp4"){
            if($upload->type=="pdf"){
                $request->validate([
                    'file' => 'required|file|mimetypes:application/pdf|max:20480',
                ]);                
            }
            if($upload->type=="mp4"){
                $request->validate([
                    'file' => 'required|file|mimetypes:video/mp4|max:307200', 
                ]);                
            }
            
            //處理檔案上傳        
            if ($request->hasFile('file')) {                
                $file = $request->file('file');
                $info = [
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                ];            
            }

            $FileName = safeFileName($info['original_filename'],$upload->id);            

            if($file->storeAs('privacy/fills/'.$upload->report_id.'/'.$school_name, $FileName)){
                //上傳成功
                //return back()->withErrors(['error' => ['檔案上傳成功！']]);
            }else{
                return back()->withErrors(['error' => ['檔案上傳失敗！; 請重新上傳']]);
            }
            
            $att['filename'] = $FileName;        
        }elseif($upload->type=="url"){
            $request->validate([
                'url' => 'required',
            ]);
            $att['filename'] = $request->input('url');
        }

        $att['school_code'] = $school_code; 
        $att['school_name'] = $school_name;             
        $att['upload_id'] = $upload->id; 
        $att['report_id'] = $upload->report_id; 
        $att['user_id'] = auth()->user()->id; 

        //是不是上傳過了
        $check_fill = Fill::where('upload_id',$upload->id)->where('school_code','like','%'.auth()->user()->school_code.'%')->first();
        if(empty($check_fill)){
            Fill::create($att);            
        }else{
            if(file_exists(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename))){
                unlink(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename));
            };
            if($file->storeAs('privacy/fills/'.$upload->report_id.'/'.$school_name, $FileName)){
                //上傳成功
                //return back()->withErrors(['error' => ['檔案上傳成功！']]);
            }
            $att['disable'] = null;
            $check_fill->update($att);
        }
            

        return back()->withErrors(['error' => ['檔案上傳成功！']]);
    }

    public function open_file(Report $report,$file_name){
        $school_code = get_schoool_code(auth()->user()->school_code);            
        $school_name_array = config('pd.schools_name');        
        $school_name = $school_name_array[$school_code];

        $file = storage_path('app/privacy/fills/'.$report->id.'/'. $school_name .'/'. $file_name);
        return response()->file($file);
    }
}


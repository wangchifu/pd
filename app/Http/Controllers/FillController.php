<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fill;
use App\Models\Report;
use App\Models\Upload;
use App\Models\School;

class FillController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','DESC')->get();
        $data = [
            'reports'=>$reports,
        ];
        return view('fills.index',$data);
    }

    public function create(Report $report){
        if ($report->start_date > date('Y-m-d') or $report->stop_date < date('Y-m-d')) {
            return back()->withErrors(['error' => ['現在不是填報日期！']]);
        }
        $data = [
            'report'=>$report,
        ];
        return view('fills.create',$data);
    }

    public function store(Request $request,Upload $upload){
        
        $school_code = get_schoool_code(auth()->user()->school_code);            
        $school_name_array = config('pd.schools_name');        
        $school_name = $school_name_array[$school_code];
        
        if($upload->type=="pdf"){
            $request->validate([
                'file' => 'required|file|max:5120', // 10240 KB = 10 MB     
            ]);
            //處理檔案上傳        
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $info = [
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                ];            
            }
            
            $file->storeAs('public/fills/'.$upload->report_id.'/'.$school_name, $info['original_filename']);

            $att['filename'] = $info['original_filename'];
        }else{
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
            if(file_exists(storage_path('app/public/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename))){
                unlink(storage_path('app/public/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename));
            };
            $check_fill->update($att);
        }
            

        return back();
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Upload;
use App\Models\Comment;
use App\Models\Fill;
use App\Models\SchoolAssign;
use App\Models\Score;
use App\Models\Opinion;

class ReportController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','DESC')->paginate(4);
        $data = [
            'reports'=>$reports,
        ];

        return view('reports.index',$data);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'start_date' => 'required',
            'stop_date' => 'required',
        ]);
        $att = $request->all();
        $att['user_id'] = auth()->user()->id;
        Report::create($att);

        return back();
    }

    public function upload_create(Report $report){
        $data = [
            'report'=>$report,
        ];
        return view('reports.upload_create',$data);
    }

    public function upload_store(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        $att = $request->all();        
        Upload::create($att);
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function upload_destroy(Upload $upload){
        if($upload->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }
        $upload->delete();
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function upload_edit(Upload $upload){
        $report = $upload->report;        
        $data = [
            'report'=>$report,
            'upload'=>$upload,
        ];
        return view('reports.upload_edit',$data);
    }

    public function upload_update(Request $request,Upload $upload){
        $request->validate([
            'title' => 'required',
        ]);
        if($upload->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }
        $att = $request->all();        
        $upload->update($att);
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }
    
    public function upload_copy(Request $request,Report $report){
        $request->validate([
            'id' => 'required',
        ]);
        $id = $request->input('id');
        $old_report = Report::find($id);
        if(empty($old_report->id)){
            return back()->withErrors(['error' => ['沒有此 id']]);
        }
        if($old_report->id == $report->id){
            return back()->withErrors(['error' => ['自己的 id 是要怎樣複製到自己？']]);
        }
        foreach($old_report->uploads as $upload){
            $att['title'] = $upload->title;
            $att['order_by'] = $upload->order_by;
            $att['type'] = $upload->type;
            $att['report_id'] = $report->id;
            $att['user_id'] = auth()->user()->id;
            Upload::create($att);
        }
        
        return back();
    }

    public function edit(Report $report){
                
        $data = [
            'report'=>$report,            
        ];
        return view('reports.edit',$data);
    }

    public function update(Request $request,Report $report){   
        $request->validate([
            'title' => 'required',
            'start_date' => 'required',
            'stop_date' => 'required',
        ]);     
        if($report->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }
        $att = $request->all();
        
        $report->update($att);
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function destroy(Report $report){
        if($report->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }

        Upload::where('report_id',$report->id)->delete();
        Comment::where('report_id',$report->id)->delete();
        Fill::where('report_id',$report->id)->delete();
        SchoolAssign::where('report_id',$report->id)->delete();
        Score::where('report_id',$report->id)->delete();
        Opinion::where('report_id',$report->id)->delete();
        
        $report->delete();
        if(file_exists(storage_path('app/privacy/fills/'.$report->id))){
            del_folder(storage_path('app/privacy/fills/'.$report->id));
        }
        
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function comment_create(Report $report){        
        $uploads = Upload::where('report_id',$report->id)->orderBy('order_by')->get();
        if(count($uploads)==0){
            //return back()->withErrors(['errors' => ['必須先建立 1.上傳項目']]);
            echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
        }
        $data = [
            'report'=>$report,
            'uploads'=>$uploads,
        ];
        return view('reports.comment_create',$data);
    }

    public function comment_store(Request $request){
        $request->validate([
            'title' => 'required',
            'score' => 'required',
        ]);

        $att = $request->all();        
        if(!empty($att['refer'])){
            $att['refer'] = serialize($att['refer']);
        }        
        Comment::create($att);
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function comment_destroy(Comment $comment){
        if($comment->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }
        $comment->delete();
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function comment_edit(Comment $comment){ 
        $report = $comment->report;

        $cbs = (!empty($comment->refer))?unserialize($comment->refer):[];
        $check_refer = [];
        foreach($cbs as $k=>$v){
            $check_refer[$v] = "checked";
        }
        
        
        $uploads = Upload::where('report_id',$comment->report_id)->orderBy('order_by')->get();
        $data = [
            'report'=>$report,
            'comment'=>$comment,
            'check_refer'=>$check_refer,
            'uploads'=>$uploads,
        ];
        return view('reports.comment_edit',$data);
    }

    public function comment_update(Request $request,Comment $comment){
        $request->validate([
            'title' => 'required',
            'score' => 'required',
        ]);


        if($comment->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }
        $att = $request->all();    
        if(!empty($att['refer'])){
            $att['refer'] = serialize($att['refer']);
        }else{
            $att['refer'] = null;
        }    
        $comment->update($att);
        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }
    
    public function comment_copy(Request $request,Report $report){
        $request->validate([
            'id' => 'required',
        ]); 
        $id = $request->input('id');
        $old_report = Report::find($id);
        if(empty($old_report->id)){
            return back()->withErrors(['error' => ['沒有此 id']]);
        }

        if($old_report->id == $report->id){
            return back()->withErrors(['error' => ['自己的 id 是要怎樣複製到自己？']]);
        }

        $check_uploads = Upload::where('report_id',$report->id)->orderBy('order_by')->get();
        if(count($check_uploads)==0){
            return back()->withErrors(['errors' => ['必須先建立 1.上傳項目']]);            
        }

        $p=1;
        foreach($old_report->comments as $comment){
            $att['title'] = $comment->title;
            $att['order_by'] = $comment->order_by;
            $att['score'] = $comment->score;
            
            
            //refer要refer新的upload            
            if($comment->refer){
                $old_refer_array = unserialize($comment->refer);
                $old_uploads = Upload::whereIn('id',$old_refer_array)->get();
                $n= 0 ;
                foreach($old_uploads as $old_upload){
                    $new_upload = Upload::where('title',$old_upload->title)->where('report_id',$report->id)->first();
                    $new_refer_array[$n] = $new_upload->id;
                    $n++;
                }
                $att['refer'] = serialize($new_refer_array);
            }else{
                $att['refer'] = $comment->refer;
            }

                                                
            $att['standard'] = $comment->standard;
            $att['report_id'] = $report->id;
            $att['user_id'] = auth()->user()->id;

            Comment::create($att);
        }
        
        return back();
    }

}

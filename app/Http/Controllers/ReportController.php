<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Upload;
use App\Models\Comment;

class ReportController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','DESC')->paginate(4);;
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
        $att = $request->all();        
        Upload::create($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function upload_destroy(Upload $upload){
        if($upload->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $upload->delete();
        echo "<body onload=\"opener.location.reload();;window.close();\">";
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
        if($upload->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $att = $request->all();        
        $upload->update($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }
    
    public function upload_copy(Request $request,Report $report){
        $id = $request->input('id');
        $old_report = Report::find($id);
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
        if($report->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $att = $request->all();
        
        $report->update($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function destroy(Report $report){
        if($report->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }

        Upload::where('report_id',$report->id)->delete();

        $report->delete();
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function comment_create(Report $report){
        $uploads = Upload::orderBy('order_by')->get();
        $data = [
            'report'=>$report,
            'uploads'=>$uploads,
        ];
        return view('reports.comment_create',$data);
    }

    public function comment_store(Request $request){
        $att = $request->all();        
        if(!empty($att['refer'])){
            $att['refer'] = serialize($att['refer']);
        }        
        Comment::create($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function comment_destroy(Comment $comment){
        if($comment->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $comment->delete();
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function comment_edit(Comment $comment){
        $report = $comment->report;

        $cbs = (!empty($comment->refer))?unserialize($comment->refer):[];
        $check_refer = [];
        foreach($cbs as $k=>$v){
            $check_refer[$v] = "checked";
        }
        
        
        $uploads = Upload::orderBy('order_by')->get();
        $data = [
            'report'=>$report,
            'comment'=>$comment,
            'check_refer'=>$check_refer,
            'uploads'=>$uploads,
        ];
        return view('reports.comment_edit',$data);
    }

    public function comment_update(Request $request,Comment $comment){
        if($comment->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $att = $request->all();    
        if(!empty($att['refer'])){
            $att['refer'] = serialize($att['refer']);
        }else{
            $att['refer'] = null;
        }    
        $comment->update($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }
    
    public function comment_copy(Request $request,Report $report){
        $id = $request->input('id');
        $old_report = Report::find($id);
        foreach($old_report->comments as $comment){
            $att['title'] = $comment->title;
            $att['order_by'] = $comment->order_by;
            $att['score'] = $comment->score;
            $att['standard'] = $comment->standard;
            $att['report_id'] = $report->id;
            $att['user_id'] = auth()->user()->id;
            Comment::create($att);
        }
        
        return back();
    }

}

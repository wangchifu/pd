<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    public function index(){
        $link1s = Link::where('side','left')->orderBy('order_by')->get();
        $link2s = Link::where('side','right')->orderBy('order_by')->get();

        $data = [
            'link1s'=>$link1s,            
            'link2s'=>$link2s,            
        ];
        return view('links.index',$data);
    }

    public function store(Request $request){        
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);
        $att = $request->all();        
        $att['user_id'] = auth()->user()->id;        
        Link::create($att);

        return redirect()->route('link.index');
    }

    public function destroy(Link $link)
    {
        if (auth()->user()->id != $link->user_id) {
            return back();
        }        
        $link->delete();

        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }

    public function edit(Link $link){
                
        $data = [
            'link'=>$link,            
        ];
        return view('links.edit',$data);
    }

    public function update(Request $request,Link $link){
        if (auth()->user()->id != $link->user_id) {
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);
        }   
        $att = $request->all();                
        $link->update($att);

        echo "<body onload=\"window.parent.location.reload();window.parent.postMessage('closeVenobox', '*'); \">";
    }
}

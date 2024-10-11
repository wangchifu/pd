<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Item;

class YearController extends Controller
{
    public function index(){
        $years = Year::orderBy('year_name','DESC')->get();
        $data = [
            'years'=>$years,
        ];

        return view('years.index',$data);
    }

    public function store(Request $request){
        $att = $request->all();
        $att['user_id'] = auth()->user()->id;
        Year::create($att);

        return back();
    }

    public function create_item(Year $year){
        $data = [
            'year'=>$year,
        ];
        return view('years.create_item',$data);
    }

    public function item_store(Request $request){
        $att = $request->all();        
        Item::create($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function item_destroy(Item $item){
        if($item->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $item->delete();
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function edit_item(Item $item){
        $year = $item->year;
        
        $data = [
            'year'=>$year,
            'item'=>$item,
        ];
        return view('years.edit_item',$data);
    }

    public function item_update(Request $request,Item $item){
        if($item->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $att = $request->all();        
        $item->update($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }
    public function copy_year(Request $request,Year $year){
        $id = $request->input('id');
        $old_year = Year::find($id);
        foreach($old_year->items as $item){
            $att['title'] = $item->title;
            $att['order_by'] = $item->order_by;
            $att['type'] = $item->type;
            $att['year_id'] = $year->id;
            $att['user_id'] = auth()->user()->id;
            Item::create($att);
        }
        
        return back();
    }

    public function edit_year(Year $year){
                
        $data = [
            'year'=>$year,            
        ];
        return view('years.edit_year',$data);
    }

    public function update_year(Request $request,Year $year){        
        if($year->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }
        $att = $request->all();
        
        $year->update($att);
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

    public function year_destroy(Year $year){
        if($year->user_id != auth()->user()->id){
            return back()->withErrors(['errors' => ['這個項目不是你建立的！']]);;
        }

        Item::where('year_id',$year->id)->delete();

        $year->delete();
        echo "<body onload=\"opener.location.reload();;window.close();\">";
    }

}

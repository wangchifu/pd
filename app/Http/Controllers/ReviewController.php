<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;

class ReviewController extends Controller
{
    public function index(){

        $reports = Report::orderBy('id','DESC')->paginate(4);

        $reviewer = User::where('review',1)->get();
        $data = [
            'reports'=>$reports,
            'reviewer'=>$reviewer,
        ];

        return view('reviews.index',$data);
    }
}

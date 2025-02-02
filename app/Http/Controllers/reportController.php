<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class reportController extends Controller
{
    public function query_fn(){
        return view('/admin/.report.query' );
    }

    public function menu_fn(){
        return view('/admin/.report.menu' );
    }

    public function weekly_assignment_fn(){
        return view('/admin/.report.weekly_assignment' );
    }
    public function gross_margin_fn(){
        return view('/admin/.report.gross_margin' );
    }

}

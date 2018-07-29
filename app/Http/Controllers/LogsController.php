<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use View;
use Session;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function list(Request $request){
        $getLogs = Log::whereNotNull('id');

        if(!empty($request->get('system'))){
            $getLogs->where('system', $request->get('system'));
        }

        if(!empty($request->get('action'))){
            $getLogs->where('action', $request->get('action'));
        }

        if($request->has('date')){
             $getLogs->whereDate('created_at', '=', Carbon::createFromFormat('d/m/Y', $request->get('date'))->format('Y-m-d'));
        }
        
        $logs = $getLogs->orderBy('created_at', 'DESC')->paginate(10);

        return View::make('logs.list')->with(compact('logs'));
    }
}

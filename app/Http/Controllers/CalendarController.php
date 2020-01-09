<?php

namespace App\Http\Controllers;
use App\Holiday;
use App\Calendar;
use Illuminate\Http\Request;

use Auth;

class CalendarController extends Controller
{
    public function index2(Request $request){
        //$list = Holiday::all();
        $list = Holiday::where('user_id',Auth::user()->id) 
->get();
// ddd($list);
       $cal = new Calendar($list);
        $tag = $cal->showCalendarTag($request->month,$request->year);

        return view('calendar.index2', ['cal_tag' => $tag]); 
    }
    public function getHoliday(Request $request)
    {
        // 休日データ取得
       $data = new Holiday(); 
       //$list = Holiday::all();
       $list = Holiday::where('user_id',Auth::user()->id) 
->get();
        return view('calendar.holiday', ['list' => $list,'data' => $data]);
    }
    public function getHolidayId($id)
    {
        // 休日データ取得
	$data = new Holiday();

       if (isset($id)) {
$data = Holiday::where('user_id',Auth::user()->id)->first(); 
            //$data = Holiday::where('id', '=', $id)->first();
        } 
        $list = Holiday::all();
        // $cal = new Calendar();
        //return view('calendar.holiday', ['list' => $list]); 
        return view('calendar.holiday', ['list' => $list,'data' => $data]);       
    }
    public function deleteHoliday(Request $request)
    {
        // DELETEで受信した休日データの削除
	if (isset($request->id)) {
            $holiday = Holiday::where('user_id',Auth::user()->id)->first();
            //$holiday->user_id = Auth::user()->id;
            // $holiday = Holiday::find('user_id');
            $holiday->delete();
            return redirect()->route('holiday.index2');
	}
$data = new Holiday();
        $list = Holiday::all();
        return view('calendar.holiday', ['list' => $list, 'data' => $data]);
    }

    public function postHoliday(Request $request)
    {$validatedData = $request->validate([
        'day' => 'required|date_format:Y-m-d',
        'description' => 'required',
    ]);

        // POSTで受信した休日データの登録
       if (isset($request->id)) { 
        $holiday = Holiday::where('id', '=', $request->id)->first();
        $holiday->user_id = Auth::user()->id;
        $holiday->day = $request->day;
        $holiday->description = $request->description;        
        $holiday->save();
} else {
        $holiday = new Holiday(); 
        $holiday->user_id = Auth::user()->id;
        $holiday->day = $request->day;
        $holiday->description = $request->description;        
        $holiday->save();
	}

        // 休日データ取得
        $data = new Holiday();
        $holiday->user_id = Auth::user()->id;
        $list = Holiday::all();
        return view('calendar.holiday', ['list' => $list,'data' => $data]);
    }
}
//         $list = Holiday::all();
        
//         $cal = new Calendar($list);
// 	$tag = $cal->showCalendarTag($request->month,$request->year);
        
//         return view('calendar.index', ['cal_tag' => $tag]);
//     }
//  public function getHoliday(Request $request)
//     {// 休日データ取得
//         $data = new Holiday();
//         $list = Holiday::all();
//         return view('calendar.holiday', ['list' => $list]);        
//     }

//     public function postHoliday(Request $request)
//     {
//         $validatedData = $request->validate([
//         'day' => 'required|date_format:Y-m-d',
//         'description' => 'required',
//     ]);

//         // POSTで受信した休日データの登録
//         if (isset($request->id)) {
//         $holiday = new Holiday(); 
//         $holiday->user_id = Auth::user()->id;
//         $holiday->day = $request->day;
//         $holiday->description = $request->description;        
//         $holiday->save();
//         }
//         else {
//         $holiday = new Holiday(); 
//         $holiday->day = $request->day;
//         $holiday->description = $request->description;        
//         $holiday->save();
// 	}
//         // 休日データ取得
//         $data = new Holiday();
//         $list = Holiday::all();
//         return view('calendar.holiday', ['list' => $list]);
//     }  
    //  public function index2(Request $request)
    // {
    //     $cal = new Calendar();
    //     $tag = $cal->showCalendarTag($request->month,$request->year);

    //     return view('calendar.index2', ['cal_tag' => $tag]);
    // }
 
//}

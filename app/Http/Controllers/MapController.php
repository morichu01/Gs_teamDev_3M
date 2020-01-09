<?php

namespace App\Http\Controllers;
use App\Map;
use Illuminate\Http\Request;
use Auth;

class MapController extends Controller
{
public function index3(Request $request)
    {
        // 全Mapデータ取得
        $list = Map::all();
        //$list = Map::where('user_id',Auth::user()->id)
        
        return view('map.data', ['list' => $list]);        
    }
    public function getMap($id)
    //public function getMap(Request $request)
    {
        // 指定のMapデータ取得
        $map = Map::find($id);
        //$map = Map::where('user_id',Auth::user()->id);
        return view('map.show', ['map' => $map]);
    }
    public function postMap(Request $request)
    //public function postMap($id)
    {
        // POSTで受信したMapデータの登録
        $map = new Map(); 
        $map->user_id=Auth::user()->id;
        $map->name = $request->name;
        $map->lat = $request->lat;
        $map->lng = $request->lng;
        $map->description = $request->description;        
        $map->save();
        // Mapデータ取得
        $list = Map::all();
        return view('map.data', ['list' => $list]);
    }
}

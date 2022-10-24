<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Configuration;

class ConfigurationsController extends Controller
{
    public function getColumns(Request $request,$table){
        $types = DB::select( DB::raw('SHOW COLUMNS FROM `'.$table.'`'));
        return $types;
    }
    
    public function columnsSave(Request $request)
    {
        $configurations = Configuration::where('userid','=',$request->userId)
            ->where('page','=',$request->page)
            ->first();
        if(!$configurations){
            $configurations = new Configuration([
                'page' => $request->page,
                'userId' => $request->userId,
                'json' => $request->json,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
        else{
            $configurations->page = $request->page;
            $configurations->userId = $request->userId;
            $configurations->json = $request->json;
            $configurations->updated_at = date("Y-m-d H:i:s");
        }
        
        if($configurations->save()){
            return response()->json([
            'message' => 'Configuracao salva com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    
    public function columns(Request $request, $page)
    {
        $id =  $request->userId;
        $configurations =  Configuration::select('json')
            ->where('userid',$id)
            ->where('page',$page)
            ->first();
        $return = $configurations? json_decode($configurations->json): null;
        return response()->json(['data' => $return ], 200);
    }
}

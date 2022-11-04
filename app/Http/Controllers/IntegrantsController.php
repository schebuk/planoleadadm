<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\IntegrantssExport;
use App\Exports\IntegrantssExportTemplate;
use App\Imports\IntegrantssImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

use App\Models\Integrants;

class IntegrantssController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['id', 'name','status','created_at'];

        $length = $request->input('length');
        $column = $request->input('column') == 0? 'id':$request->input('column');
        $dir = $request->input('dir') == null? 'DESC':$request->input('dir');
        $searchValue = $request->input('search');
        $searchField = $request->input('searchField');
        $searchValue2 = $request->input('search2');
        $searchType = 'LIKE';
        $searchType2 = 'LIKE';

        switch ($request->input('searchType')){
            case 'contains':
                $searchValue = '%' . $searchValue . '%';
                break;
            case 'start':
                $searchValue = $searchValue . '%';
                break;
            case 'end':
                $searchValue = '%' . $searchValue;
                break;
            case 'equal':
                $searchType = '=';
                if ($searchValue == 0){
                    $searchValue = 1;
                    $searchType = '!=';
                }
                break;
            case 'notequal':
                $searchType = '<>';
                break;
            case 'greater':
                $searchType = '>';
                break;
            case 'greaterequal':
                $searchType = '>=';
                break;
            case 'lesser':
                $searchType = '<';
                break;
            case 'lesserequal':
                $searchType = '<=';
                break;
        }
        
        switch ($request->input('searchType2')){
            case 'contains':
                $searchValue2 = '%' . $searchValue2 . '%';
                break;
            case 'start':
                $searchValue2 = $searchValue2 . '%';
                break;
            case 'end':
                $searchValue2 = '%' . $searchValue2;
                break;
            case 'equal':
                $searchType2 = '=';
                break;
            case 'notequal':
                $searchType2 = '<>';
                break;
            case 'greater':
                $searchType2 = '>';
                break;
            case 'greaterequal':
                $searchType = '>=';
                break;
            case 'lesser':
                $searchType2 = '<';
                break;
            case 'lesserequal':
                $searchType2 = '<=';
                break;
        }

        $query =  Integrants::orderBy($column, $dir);

        if ($searchValue && $searchField) {
            if ($request->input('search2')){
                switch ($request->input('operator')){
                    case 'AND':
                        $query->where(function($query) use ($searchValue, $searchField, $searchType, $searchValue2, $searchType2) {
                            $query->where($searchField, $searchType, $searchValue)
                                ->where($searchField, $searchType2, $searchValue2);
                        });
                        break;
                    case 'OR':
                        $query->where(function($query) use ($searchValue, $searchField, $searchType, $searchValue2, $searchType2) {
                            $query->where($searchField, $searchType,$searchValue)
                            ->orWhere($searchField, $searchType2,$searchValue2);
                        });
                        break;
                }
            }
            else{
                $query->where(function($query) use ($searchValue, $searchField, $searchType) {
                    $query->where($searchField, $searchType,$searchValue);
                });
            }
        }

        $registers = $query
            ->where('trash','=',0)
            ->where('delete','=',0)
            ->paginate($length);
        return ['data' => $registers, 'draw' => $request->input('draw')];
    }

    public function getTrashList(Request $request)
    {
        $columns = ['id', 'name','status','created_at'];

        $length = $request->input('length');
        $column = $request->input('column') == 0? 'id':$request->input('column');
        $dir = $request->input('dir')? $request->input('dir'):'DESC';
        $searchValue = $request->input('search');
        $searchField = $request->input('searchField');
        $searchValue2 = $request->input('search2');
        $searchType = 'LIKE';
        $searchType2 = 'LIKE';

        switch ($request->input('searchType')){
            case 'contains':
                $searchValue = '%' . $searchValue . '%';
                break;
            case 'start':
                $searchValue = $searchValue . '%';
                break;
            case 'end':
                $searchValue = '%' . $searchValue;
                break;
            case 'equal':
                $searchType = '=';
                if ($searchValue == 0){
                    $searchValue = 1;
                    $searchType = '!=';
                }
                break;
            case 'notequal':
                $searchType = '<>';
                break;
            case 'greater':
                $searchType = '>';
                break;
            case 'greaterequal':
                $searchType = '>=';
                break;
            case 'lesser':
                $searchType = '<';
                break;
            case 'lesserequal':
                $searchType = '<=';
                break;
        }
        
        switch ($request->input('searchType2')){
            case 'contains':
                $searchValue2 = '%' . $searchValue2 . '%';
                break;
            case 'start':
                $searchValue2 = $searchValue2 . '%';
                break;
            case 'end':
                $searchValue2 = '%' . $searchValue2;
                break;
            case 'equal':
                $searchType2 = '=';
                break;
            case 'notequal':
                $searchType2 = '<>';
                break;
            case 'greater':
                $searchType2 = '>';
                break;
            case 'greaterequal':
                $searchType = '>=';
                break;
            case 'lesser':
                $searchType2 = '<';
                break;
            case 'lesserequal':
                $searchType2 = '<=';
                break;
        }

        $query =  Integrants::select('id', 'name','status','created_at')->orderBy($column, $dir);

        if ($searchValue && $searchField) {
            if ($request->input('search2')){
                switch ($request->input('operator')){
                    case 'AND':
                        $query->where(function($query) use ($searchValue, $searchField, $searchType, $searchValue2, $searchType2) {
                            $query->where($searchField, $searchType, $searchValue)
                                ->where($searchField, $searchType2, $searchValue2);
                        });
                        break;
                    case 'OR':
                        $query->where(function($query) use ($searchValue, $searchField, $searchType, $searchValue2, $searchType2) {
                            $query->where($searchField, $searchType,$searchValue)
                            ->orWhere($searchField, $searchType2,$searchValue2);
                        });
                        break;
                }
            }
            else{
                $query->where(function($query) use ($searchValue, $searchField, $searchType) {
                    $query->where($searchField, $searchType,$searchValue);
                });
            }
        }

        $registers = $query
            ->where('trash','=',1)
            ->where('delete','=',0)
            ->paginate($length);
        return ['data' => $registers, 'draw' => $request->input('draw')];
    }
    
    public function getById(Request $request,$id)
    {
        return Integrants::select('id', 'name','status','created_at')
            ->where('id','=',$id)
            ->first();
    }

    public function save(Request $request)
    {  
        $registers = new Integrants([
            'name' => $request->name,
            'status' => $request->status,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'trash' => 0,
            'delete' => 0
        ]);
        if($registers->save()){
            return response()->json([
            'message' => 'Integrantso editado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    
    public function edit(Request $request)
    {
        /*$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telephone' => 'required|integer|min:10',
            'user' => 'required|string',
            'regraId' => 'required|integer',
            'status' => 'boolean',
        ]);*/
        $registers = Integrants::where('id','=',$request->id)->first();
          
        $registers->name = $request->name;;
        $registers->status = $request->status;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Integrantso editado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function trash(Request $request, $id)
    {
        $registers = Integrants::where('id','=',$id)->first();
          
        $registers->trash = 1;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'Integrantso mandado para lixeira com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function restore(Request $request, $id)
    {
        $registers = Integrants::where('id','=',$id)->first();
          
        $registers->trash = 0;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Integrantso Restaurado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function delete(Request $request, $id)
    {
        $registers = Integrants::where('id','=',$id)->first();
          
        $registers->delete = 1;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Integrantso deletado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function status(Request $request, $id, $status)
    {
        $registers = Integrants::where('id','=',$id)->first();
          
        $registers->status = $status;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'alterado status do Integrantso com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function import(Request $request) 
    {
        $validatedData = $request->validate([
           'file' => 'required',
        ]);
        Excel::import(new IntegrantssImport,$request->file('file'));
           
        
        return response()->json([
            'message' => 'importado com sucesso'
            ], 200);
    }
    public function export(Request $request) 
    {
        return Excel::download(new IntegrantssExport, 'segments.csv');
    }
    public function exportTemplate(Request $request) 
    {
        return Excel::download(new IntegrantssExportTemplate(), 'segmentstemplate.csv');
    }
    public function getTrash(Request $request) 
    {
        $registers = Integrants::select('id', 'name')
            ->where('trash','=',1)
            ->where('delete','!=',1)
            ->orderBy('id', 'desc')
            ->get();
        return $registers;
    }
    public function massEdit(Request $request){
        $ids = explode(',',$request->ids);
        $update = [];

        $update["updated_at"] = date("Y-m-d H:i:s");
        $registers = Integrants::whereIn('id',$ids)
            ->update($update);
        
        if($registers){
            return response()->json([
            'message' => count($ids).' Registros editados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }

        
    }
    public function massTrash(Request $request){
        $ids = explode(',',$request->ids);
        $registers = Integrants::whereIn('id',$ids)
            ->update([
                'trash'=>1,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($registers){
            return response()->json([
            'message' => count($ids).' Registros mandados para lixeira com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
    public function massRestore(Request $request){
        $ids = explode(',',$request->ids);
        $registers = Integrants::whereIn('id',$ids)
            ->update([
                'trash'=>0,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($registers){
            return response()->json([
            'message' => count($ids).' Registros restaurados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
    public function massDelete(Request $request){
        $ids = explode(',',$request->ids);
        $registers = Integrants::whereIn('id',$ids)
            ->update([
                'delete'=>1,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($registers){
            return response()->json([
            'message' => count($ids).' Registros deletados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
}

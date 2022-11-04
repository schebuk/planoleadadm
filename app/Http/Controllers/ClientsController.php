<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ClientssExport;
use App\Exports\ClientssExportTemplate;
use App\Imports\ClientssImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

use App\Models\Clients;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['id', 'name', 'email', 'user','telephone','regraId','status','created_at'];

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

        $query =  Clients::orderBy($column, $dir);

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

        $users = $query
            ->where('trash','=',0)
            ->where('delete','=',0)
            ->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];
    }

    public function getTrashList(Request $request)
    {
        $columns = ['id', 'name', 'email', 'user','telephone','regraId','status','created_at'];

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

        $query =  Clients::select('id', 'name', 'email', 'user', 'telephone', 'regraId', 'status','created_at')->orderBy($column, $dir);

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

        $users = $query
            ->where('trash','=',1)
            ->where('delete','=',0)
            ->where('name','!=','admin')
            ->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];
    }
    
    public function getClientsById(Request $request,$id)
    {
        return Clients::select('id', 'name', 'email', 'user','telephone','regraId','status','created_at')
            ->where('id','=',$id)
            ->first();
    }

    public function save(Request $request)
    {  
        $user = new Clients([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'user' => $request->user,
            'regraId' => $request->regraId,
            'status' => $request->status,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('123456'),
            'trash' => 0,
            'delete' => 0
        ]);
        if($user->save()){
            return response()->json([
            'message' => 'Usuario editado com sucesso'
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
        $user = Clients::where('id','=',$request->id)->first();
          
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->user = $request->user;
        $user->regraId = $request->regraId;
        $user->status = $request->status;
        $user->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario editado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function trash(Request $request, $id)
    {
        $user = Clients::where('id','=',$id)->first();
          
        $user->trash = 1;
        $user->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario mandado para lixeira com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function restore(Request $request, $id)
    {
        $user = Clients::where('id','=',$id)->first();
          
        $user->trash = 0;
        $user->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario Restaurado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function delete(Request $request, $id)
    {
        $user = Clients::where('id','=',$id)->first();
          
        $user->delete = 1;
        $user->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario deletado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function status(Request $request, $id, $status)
    {
        $user = Clients::where('id','=',$id)->first();
          
        $user->status = $status;
        $user->updated_at = date("Y-m-d H:i:s");
        
        if($user->save()){
            return response()->json([
            'message' => 'alterado status do Usuario com sucesso'
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
        Excel::import(new ClientssImport,$request->file('file'));
           
        
        return response()->json([
            'message' => 'importado com sucesso'
            ], 200);
    }
    public function export(Request $request) 
    {
        return Excel::download(new ClientssExport, 'users.csv');
    }
    public function exportTemplate(Request $request) 
    {
        return Excel::download(new ClientssExportTemplate(), 'userstemplate.csv');
    }
    public function getTrash(Request $request) 
    {
        $users = Clients::select('id')
            ->where('trash','=',1)
            ->where('delete','!=',1)
            ->orderBy('id', 'desc')
            ->get();
        return $users;
    }
    public function massEdit(Request $request){
        $ids = explode(',',$request->ids);
        $update = [];
        if ($request->regraId){
            $update["regraId"] = $request->regraId;
        }
        if ($request->status != ''){
            $update["status"] = $request->status;
        }
        
        $update["updated_at"] = date("Y-m-d H:i:s");
        $users = Clients::whereIn('id',$ids)
            ->update($update);
        
        if($users){
            return response()->json([
            'message' => count($ids).' Registros editados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }

        
    }
    public function massTrash(Request $request){
        $ids = explode(',',$request->ids);
        $users = Clients::whereIn('id',$ids)
            ->update([
                'trash'=>1,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($users){
            return response()->json([
            'message' => count($ids).' Registros mandados para lixeira com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
    public function massRestore(Request $request){
        $ids = explode(',',$request->ids);
        $users = Clients::whereIn('id',$ids)
            ->update([
                'trash'=>0,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($users){
            return response()->json([
            'message' => count($ids).' Registros restaurados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
    public function massDelete(Request $request){
        $ids = explode(',',$request->ids);
        $users = Clients::whereIn('id',$ids)
            ->update([
                'delete'=>1,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
                    
        if($users){
            return response()->json([
            'message' => count($ids).' Registros deletados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
        
    }
}

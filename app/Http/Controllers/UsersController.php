<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
    	if ( $request->input('client') ) {
    	    return User::select('id', 'name', 'email', 'user','telephone','regraId','status','created_at')
            ->where('trash','=',0)
            ->where('delete','=',0)
            ->where('name','!=','admin')
            ->get();
    	}

        $columns = ['id', 'name', 'email', 'user','telephone','regraId','status','created_at'];

        $length = $request->input('length');
        $column = $request->input('column') == 0? 'id':$request->input('column');
        $dir = $request->input('dir');
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

        $query =  User::select('id', 'name', 'email', 'user', 'telephone', 'regraId', 'status','created_at')->orderBy($column, $dir);

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
            ->where('name','!=','admin')
            ->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];
    }
    
    public function getUserById(Request $request,$id)
    {
        return User::select('id', 'name', 'email', 'user','telephone','regraId','status','created_at')
            ->where('id','=',$id)
            ->first();
    }

    public function save(Request $request)
    {
        /*$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telephone' => 'required|integer|min:10',
            'user' => 'required|string',
            'regraId' => 'required|integer',
            'status' => 'boolean',
        ]);*/
  
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'user' => $request->user,
            'regraId' => $request->regraId,
            'status' => $request->status,
            'created_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('123456')
        ]);
        if($user->save()){
            return response()->json([
            'message' => 'Usuario cadastrado com sucesso'
            ], 201);
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
        $user = User::where('id','=',$request->id)->first();
          
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
            ], 201);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function trash(Request $request, $id)
    {
        $user = User::where('id','=',$id)->first();
          
        $user->trash = 1;
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario mandado para lixeira com sucesso'
            ], 201);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function delete(Request $request, $id)
    {
        $user = User::where('id','=',$id)->first();
          
        $user->delete = 1;
        
        if($user->save()){
            return response()->json([
            'message' => 'Usuario mandado para lixeira com sucesso'
            ], 201);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function status(Request $request, $id, $status)
    {
        $user = User::where('id','=',$id)->first();
          
        $user->status = $status;
        
        if($user->save()){
            return response()->json([
            'message' => 'alterado status do Usuario com sucesso'
            ], 201);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
}

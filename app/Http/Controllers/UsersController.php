<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
    	if ( $request->input('client') ) {
    	    return User::select('id', 'name', 'email', 'user','telephone','regraId','status','created_at')->get();
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

        $users = $query->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];
    }
}

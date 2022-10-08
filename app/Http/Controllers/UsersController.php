<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
    	if ( $request->input('client') ) {
    	    return User::select('id', 'name', 'email', 'user','telephone','regraId','status')->get();
    	}

        $columns = ['id', 'name', 'email', 'user','telephone','regraId','status'];

        $length = $request->input('length');
        $column = $request->input('column') == 0? 'id':$request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $searchField = $request->input('searchField');
        $searchType = 'LIKE';

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

        $query =  User::select('id', 'name', 'email', 'user', 'telephone', 'regraId', 'status')->orderBy($column, $dir);

        if ($searchValue && $searchField) {
            $query->where(function($query) use ($searchValue, $searchField, $searchType) {
                $query->where($searchField, $searchType,$searchValue);
            });
        }

        $users = $query->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];
    }
}

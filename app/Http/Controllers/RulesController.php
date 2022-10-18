<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rules;

class RulesController extends Controller
{
    public function getSelect(Request $request, $description)
    {
    	$rules = Rules::select('id', $description . ' AS name')->get();
        
        return ['data' => $rules];
    	
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\States;

class StatesController extends Controller
{
    public function getSelect(Request $request)
    {
    	$states = States::select('id', 'name','abreviation')->get();
        
        return ['data' => $states];
    	
    }
}

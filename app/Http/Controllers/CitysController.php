<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Citys;

class CitysController extends Controller
{
    public function getSelect(Request $request, $state)
    {
    	$cities = Citys::select('id', 'name')->where('estateId', $state)->get();
        
        return ['data' => $cities];
    	
    }
}

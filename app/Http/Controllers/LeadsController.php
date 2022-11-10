<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LeadsExport;
use App\Exports\LeadsExportTemplate;
use App\Imports\LeadsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

use App\Models\Leads;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['id','name','email','telephone','cityId','adId','negReason','devReason','negDate','devDate','category','price','clientId','qualityId','integrantId','note','font','segmentId','segmentCNPJType','segmentPersonType','segmentOperator','segmentLives','exibitionDate','status','created_at','leadTypeId'];

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

        $query =  Leads::orderBy($column, $dir);

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

        $registerss = $query
            ->where('trash','=',0)
            ->where('delete','=',0)
            ->paginate($length);
        return ['data' => $registerss, 'draw' => $request->input('draw')];
    }

    public function getTrashList(Request $request)
    {
        $columns = ['id','name','email','telephone','cityId','adId','negReason','devReason','negDate','devDate','category','price','clientId','qualityId','integrantId','note','font','segmentId','segmentCNPJType','segmentPersonType','segmentOperator','segmentLives','exibitionDate','status','created_at','leadTypeId'];
        

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

        $query =  Leads::select('id','name','email','telephone','cityId','adId','negReason','devReason','negDate','devDate','category','price','clientId','qualityId','integrantId','note','font','segmentId','segmentCNPJType','segmentPersonType','segmentOperator','segmentLives','exibitionDate','status','created_at','leadTypeId')->orderBy($column, $dir);

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

        $registerss = $query
            ->where('trash','=',1)
            ->where('delete','=',0)
            ->where('name','!=','admin')
            ->paginate($length);
        return ['data' => $registerss, 'draw' => $request->input('draw')];
    }
    
    public function getLeadsById(Request $request,$id)
    {
        return Leads::select('id','name','email','telephone','cityId','adId','negReason','devReason','negDate','devDate','category','price','clientId','qualityId','integrantId','note','font','segmentId','segmentCNPJType','segmentPersonType','segmentOperator','segmentLives','exibitionDate','status','created_at','leadTypeId')
            ->where('id','=',$id)
            ->first();
    }

    public function save(Request $request)
    {  
        $registers = new Leads([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'cityId' => $request->cityId,
            'adId' => $request->adId,
            'negReason' => $request->negReason,
            'devReason' => $request->devReason,
            'negDate' => $request->negDate,
            'devDate' => $request->devDate,
            'category' => $request->category,
            'price' => $request->price,
            'clientId' => $request->clientId,
            'qualityId' => $request->qualityId,
            'integrantId' => $request->integrantId,
            'note' => $request->note,
            'font' => $request->font,
            'segmentId' => $request->segmentId,
            'segmentCNPJType' => $request->segmentCNPJType,
            'segmentPersonType' => $request->segmentPersonType,
            'segmentOperator' => $request->segmentOperator,
            'segmentLives' => $request->segmentLives,
            'exibitionDate' => $request->exibitionDate,
            'status' => $request->status,
            'leadTypeId' => $request->leadTypeId,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'trash' => 0,
            'delete' => 0
        ]);
        if($registers->save()){
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
        $registers = Leads::where('id','=',$request->id)->first();
          
        $registers->name = $request->name;
        $registers->email = $request->email;
        $registers->telephone = $request->telephone;
        $registers->cityId = $request->cityId;
        $registers->adId = $request->adId;
        $registers->negReason = $request->negReason;
        $registers->devReason = $request->devReason;
        $registers->negDate = $request->negDate;
        $registers->devDate = $request->devDate;
        $registers->category = $request->category;
        $registers->price = $request->price;
        $registers->clientId = $request->clientId;
        $registers->qualityId = $request->qualityId;
        $registers->integrantId = $request->integrantId;
        $registers->note = $request->note;
        $registers->font = $request->font;
        $registers->segmentId = $request->segmentId;
        $registers->segmentCNPJType = $request->segmentCNPJType;
        $registers->segmentPersonType = $request->segmentPersonType;
        $registers->segmentOperator = $request->segmentOperator;
        $registers->segmentLives = $request->segmentLives;
        $registers->exibitionDate = $request->exibitionDate;
        $registers->status = $request->status;
        $registers->leadTypeId = $request->leadTypeId;
        $registers->status = $request->status;
        
        if($registers->save()){
            return response()->json([
            'message' => 'Usuario editado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function trash(Request $request, $id)
    {
        $registers = Leads::where('id','=',$id)->first();
          
        $registers->trash = 1;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Usuario mandado para lixeira com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function restore(Request $request, $id)
    {
        $registers = Leads::where('id','=',$id)->first();
          
        $registers->trash = 0;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Usuario Restaurado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function delete(Request $request, $id)
    {
        $registers = Leads::where('id','=',$id)->first();
          
        $registers->delete = 1;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
            return response()->json([
            'message' => 'Usuario deletado com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }
    public function status(Request $request, $id, $status)
    {
        $registers = Leads::where('id','=',$id)->first();
          
        $registers->status = $status;
        $registers->updated_at = date("Y-m-d H:i:s");
        
        if($registers->save()){
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
        Excel::import(new LeadsImport,$request->file('file'));
           
        
        return response()->json([
            'message' => 'importado com sucesso'
            ], 200);
    }
    public function export(Request $request) 
    {
        return Excel::download(new LeadsExport, 'users.csv');
    }
    public function exportTemplate(Request $request) 
    {
        return Excel::download(new LeadsExportTemplate(), 'userstemplate.csv');
    }
    public function getTrash(Request $request) 
    {
        $registerss = Leads::select('id')
            ->where('trash','=',1)
            ->where('delete','!=',1)
            ->orderBy('id', 'desc')
            ->get();
        return $registerss;
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
        $registerss = Leads::whereIn('id',$ids)
            ->update($update);
        
        if($registerss){
            return response()->json([
            'message' => count($ids).' Registros editados com sucesso'
            ], 200);
        }else{
            return response()->json(['error'=>'Provide proper details']);
        }

        
    }
    public function massTrash(Request $request){
        $ids = explode(',',$request->ids);
        $registers = Leads::whereIn('id',$ids)
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
        $registers = Leads::whereIn('id',$ids)
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
        $registers = Leads::whereIn('id',$ids)
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

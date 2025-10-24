<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\State;
use Illuminate\Support\Facades\DB;



class StateService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        State::create([
           
            'name' => $request->name,
        ]);


        DB::commit();
    } catch (PDOException $e) {
        DB::rollback();
        throw new DatabaseException($e->getMessage());
    } catch (Exception $e) {
        DB::rollback();
        throw new GlobalException($e->getMessage());
    }
   } 





   public function update($request, $id)
   {

    try {

        DB::beginTransaction();

        State::where('id', $id)->update([
           
            'name' => $request->name,
        ]);


        DB::commit();
    } catch (PDOException $e) {
        DB::rollback();
        throw new DatabaseException($e->getMessage());
    } catch (Exception $e) {
        DB::rollback();
        throw new GlobalException($e->getMessage());
    }
   } 



   
}
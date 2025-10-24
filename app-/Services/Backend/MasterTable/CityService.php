<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\City;
use Illuminate\Support\Facades\DB;



class CityService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        City::create([
           'state_id' => $request->state,
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

        City::where('id', $id)->update([
            
            'state_id' => $request->state,
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
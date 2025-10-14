<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\Area;
use Illuminate\Support\Facades\DB;



class AreaService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        Area::create([
           'state_id' => $request->state,
           'city_id' => $request->city,
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

        Area::where('id', $id)->update([
            
            'state_id' => $request->state,
            'city_id' => $request->city,
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
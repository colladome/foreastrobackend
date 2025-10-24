<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\SubCategory;
use Illuminate\Support\Facades\DB;



class SubCategoryService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        SubCategory::create([
           'category_id' => $request->category,
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

        SubCategory::where('id', $id)->update([
            
            'category_id' => $request->category,
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
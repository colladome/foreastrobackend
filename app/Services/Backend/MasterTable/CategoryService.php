<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class CategoryService
{
  
   public function create($request)
   {

    

    try {


        $file = $request->file('image');

       
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('image')->extension();
            $fileName = $uuid . '_category';
            $documentPath = 'category';
            $filePath = $documentPath . '/' . $fileName;

            $image = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
        }



        DB::beginTransaction();
        Category::create([
           
            'name' => $request->name,
            'image' => $image,
            'order' => $request->order,
            'description' => $request->description,
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

        $file = $request->file('image');

       
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('image')->extension();
            $fileName = $uuid . 'category';
            $documentPath = 'category';
            $filePath = $documentPath . '/' . $fileName;

            $image = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
        }
        else{
           $categoryImage = Category::where('id', $id)->first();

           $image = $categoryImage->image;
        }

        DB::beginTransaction();

        Category::where('id', $id)->update([
           
            'name' => $request->name,
            'image' => $image,
            'order' => $request->order,
            'description' => $request->description,
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
<?php

namespace App\Services\Backend\MasterTable;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BannerService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();


        $file = $request->file('banner');

       
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('banner')->extension();
            $fileName = $uuid . '_banner';
            $documentPath = 'banner';
            $filePath = $documentPath . '/' . $fileName;

            $banner = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');


          
            //$this->awsS3Service->storeS3DocA($documentPath, $file, $fileName);
        }

        Banner::create([
            'link' => $request->link,
            'name' => $banner,
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


        $file = $request->file('banner');

       
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('banner')->extension();
            $fileName = $uuid . '_banner';
            $documentPath = 'banner';
            $filePath = $documentPath . '/' . $fileName;

            $banner = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');


          
            //$this->awsS3Service->storeS3DocA($documentPath, $file, $fileName);
        }

        Banner::where('id', $id)->update([
            'link' => $request->link,
            'name' => $banner,
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
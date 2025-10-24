<?php

namespace App\Services;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use App\Models\Vendor\VendorCategoryProfile;
use Illuminate\Support\Facades\Auth;




class VendorCategoryService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();

        $file = $request->file('listing_cover_image');
     
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('listing_cover_image')->extension();
            $fileName = $uuid . 'categoryProfileCoverImage';
            $documentPath = 'categoryProfileCoverImage';
            $filePath = $documentPath . '/' . $fileName;

            $categoryProfileCoverImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
        }

        $user = VendorCategoryProfile::create([
           'user_id' => Auth::id(),
           'category_id' => $request->category_id,
           'state_id' => $request->state,
           'city_id' => $request->city,
           'area_id' => $request->area,
           'business_profile_name' => $request->business_profile_name,  
           'contact_number' => $request->contact_number, 
           'address' => $request->address, 
           'pin_code' => $request->pin_code,       
           'location_link' => $request->location_link,      
           'listing_cover_image' => $categoryProfileCoverImage,      
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



   public function update($request, $categoryProfile)
   {

    try {

        $file = $request->file('listing_cover_image');
     
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('listing_cover_image')->extension();
            $fileName = $uuid . 'categoryProfileCoverImage';
            $documentPath = 'categoryProfileCoverImage';
            $filePath = $documentPath . '/' . $fileName;

            $categoryProfileCoverImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
        }
        


        DB::beginTransaction();

        VendorCategoryProfile::where('id', $categoryProfile->id)->update([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'area_id' => $request->area,
            'business_profile_name' => $request->business_profile_name,  
            'contact_number' => $request->contact_number, 
            'address' => $request->address, 
            'pin_code' => $request->pin_code,       
            'location_link' => $request->location_link,      
            'listing_cover_image' => $categoryProfileCoverImage ?? $categoryProfile->listing_cover_image,      
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
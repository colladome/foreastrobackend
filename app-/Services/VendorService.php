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



class VendorService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'mobile_number' => $request->mobile_number,
           'user_type' => 'vendor',
           'password' =>   Hash::make($request->password),
           'trusted' => $request->trusted,
           'status' => $request->status,          
        ]); 


        UserProfile::create([
            'user_id' => $user->id
        ]);


        $user->categories()->sync($request->category);

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

        $file = $request->file('avtar');
     
        if ($file) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('avtar')->extension();
            $fileName = $uuid . 'profilepic';
            $documentPath = 'profilepic';
            $filePath = $documentPath . '/' . $fileName;

            $profileImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
        }
        else{
           $profileImage = UserProfile::where('user_id', $id)->first();

           $profileImage = $profileImage->avtar;
        }


        DB::beginTransaction();

     $user = User::findOrFail($id);
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'trusted' => $request->trusted,
            'status' => $request->status,  
        ]);

        UserProfile::where('user_id', $id)->update([
            'alternate_mobile' => $request->alternate_mobile,
            'avtar' => $profileImage
        ]);

        $user->categories()->sync($request->category);


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
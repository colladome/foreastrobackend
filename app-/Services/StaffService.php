<?php

namespace App\Services;
use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserProfile;
use Spatie\Permission\Models\Role;




class StaffService
{
  
   public function create($request)
   {

    try {

        DB::beginTransaction();
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'mobile_number' => $request->mobile_number,
           'user_type' => 'staff',
           'password' =>   Hash::make($request->password),
           'status' => $request->status,          
        ]); 

        $user->syncRoles($request->role);
       // $user->assignRole($request->role);


        // UserProfile::create([
        //     'user_id' => $user->id
        // ]);

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
        $user = User::findOrFail($id);

        if(isset($request->password))
        {
           $password = Hash::make($request->password);
        }
        else{
            $password = $user->password;
        }
        DB::beginTransaction();
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'password' => $password,
            'status' => $request->status,  
        ]);

        $user->syncRoles($request->role);
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
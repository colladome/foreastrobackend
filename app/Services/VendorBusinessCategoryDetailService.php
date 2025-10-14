<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor\VendorBusinessCategoryDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor\VendorVenueSpace;
use App\Models\Vendor\VendorCategoryProfile;



class VendorBusinessCategoryDetailService
{

    public function create($request)
    {

        try {

            DB::beginTransaction();
            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();



            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'venue_criteria' => $request->venue_criteria,
                'number_of_room_available' => $request->number_of_room_available,
                'parking_availability_detial' => $request->parking_availability_detial ?? 'no',
                'ac_availability_detial' =>   $request->ac_availability_detial ?? 'no',
                'alcohol_allowed_detial' => $request->alcohol_allowed_detial ?? 'no',
                'is_your_venue_pure_vegetarian_detial' => $request->is_your_venue_pure_vegetarian_detial ?? 'no',
                'inhouse_catering_only_detial' => $request->inhouse_catering_only_detial ?? 'no',
                'per_plate_veg_price' => $request->per_plate_veg_price,
                'per_plate_non_veg_price' => $request->per_plate_non_veg_price,

            ]);



            $datas = [];

            $dataCount = count($request['space_name']);

            for ($i = 0; $i < $dataCount; $i++) {

                $datas[] = [
                    'vendor_business_category_detail_id' => $vendorBusinessCategoryDetail->id,
                    'space_name' => $request['space_name'][$i] ?? null,
                    'venue_suitable' => $request['venue_suitable'][$i + 1] ?? null,
                    'seating_pax' => $request['seating_pax'][$i] ?? null,
                    'venu_type' => $request['venu_type'][$i] ?? null,
                    'lawn_availability' => $request['lawn_availability'][$i] ?? 'no',
                    'parking_availability' => $request['parking_availability'][$i] ?? 'no',
                    'ac_availability' => $request['ac_availability'][$i] ?? 'no',
                    'inside_alcohol_permission' => $request['inside_alcohol_permission'][$i] ?? 'no',
                    'permission_to_acquire_outside_alchohol' => $request['permission_to_acquire_outside_alchohol'][$i] ?? 'no',
                    'alcohol_allowed' => $request['alcohol_allowed'][$i] ?? 'no',
                    'venue_rent' => $request['venue_rent'][$i] ?? null,

                ];
            }

            foreach ($datas as $data) {
                VendorVenueSpace::create($data);
            }


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

            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'venue_criteria' => $request->venue_criteria,
                'number_of_room_available' => $request->number_of_room_available,
                'parking_availability_detial' => $request->parking_availability_detial ?? 'no',
                'ac_availability_detial' =>   $request->ac_availability_detial ?? 'no',
                'alcohol_allowed_detial' => $request->alcohol_allowed_detial ?? 'no',
                'is_your_venue_pure_vegetarian_detial' => $request->is_your_venue_pure_vegetarian_detial ?? 'no',
                'inhouse_catering_only_detial' => $request->inhouse_catering_only_detial ?? 'no',
                'per_plate_veg_price' => $request->per_plate_veg_price,
                'per_plate_non_veg_price' => $request->per_plate_non_veg_price,
            ]);



            $datas = [];

            $dataCount = count($request['space_name']);

            for ($i = 0; $i < $dataCount; $i++) {

                $datas[] = [
                    'vendor_business_category_detail_id' => $id,
                    'space_name' => $request['space_name'][$i] ?? null,
                    'venue_suitable' => $request['venue_suitable'][$i + 1] ?? null,
                    'seating_pax' => $request['seating_pax'][$i] ?? null,
                    'venu_type' => $request['venu_type'][$i] ?? null,
                    'lawn_availability' => $request['lawn_availability'][$i] ?? 'no',
                    'parking_availability' => $request['parking_availability'][$i] ?? 'no',
                    'ac_availability' => $request['ac_availability'][$i] ?? 'no',
                    'inside_alcohol_permission' => $request['inside_alcohol_permission'][$i] ?? 'no',
                    'permission_to_acquire_outside_alchohol' => $request['permission_to_acquire_outside_alchohol'][$i] ?? 'no',
                    'alcohol_allowed' => $request['alcohol_allowed'][$i] ?? 'no',
                    'venue_rent' => $request['venue_rent'][$i] ?? null,


                ];
            }

            foreach ($datas as $data) {
                VendorVenueSpace::create($data);
            }


            DB::commit();
        } catch (PDOException $e) {
            DB::rollback();
            throw new DatabaseException($e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            throw new GlobalException($e->getMessage());
        }
    }




    public function cateringCreate($request)
    {


        try {
            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();

            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'maximum_capacity' => $request->maximum_capacity,
                'cuisine_type' => $request->cuisine_type,
                'per_plate_veg_price' => $request->per_plate_veg_price,
                'per_plate_non_veg_price' => $request->per_plate_non_veg_price

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


    public function cateringUpdate($request, $id)
    {

        try {


            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'maximum_capacity' => $request->maximum_capacity,
                'cuisine_type' => $request->cuisine_type,
                'per_plate_veg_price' => $request->per_plate_veg_price,
                'per_plate_non_veg_price' => $request->per_plate_non_veg_price
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




    public function decoratorCreate($request)
    {


        try {


            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();

            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'category_id' => $request->category_id,
                'min_price' => $request->min_price,

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


    public function decoratorUpdate($request, $id)
    {

        try {


            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'min_price' => $request->min_price,
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








    public function photographyCreate($request)
    {


        try {

            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();

            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'min_price' => $request->min_price,
                'cuisine_type' => $request->cuisine_type,
                'is_photography' => $request->is_photography,
                'is_videography' => $request->is_videography,

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


    public function photographyUpdate($request, $id)
    {

        try {



            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'min_price' => $request->min_price,
                'cuisine_type' => $request->cuisine_type,
                'is_photography' => $request->is_photography,
                'is_videography' => $request->is_videography,
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








    public function makeUpDetailCreate($request)
    {


        try {

            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();


            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'cuisine_type' => $request->cuisine_type,
                'is_trial_makeup' => $request->is_trial_makeup,
                'is_trial_makeup_free' => $request->is_trial_makeup_free,
                'makeup_trail_price' => $request->makeup_trail_price,
                'bride_makeup_price' => $request->bride_makeup_price,
                'family_makeup_price' => $request->family_makeup_price,
                'groom_makeup_price' => $request->groom_makeup_price,
                'makeup_description' => $request->makeup_description,
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


    public function makeUpDetailUpdate($request, $id)
    {

        try {



            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'cuisine_type' => $request->cuisine_type,
                'is_trial_makeup' => $request->is_trial_makeup,
                'is_trial_makeup_free' => $request->is_trial_makeup_free,
                'makeup_trail_price' => $request->makeup_trail_price,
                'bride_makeup_price' => $request->bride_makeup_price,
                'family_makeup_price' => $request->family_makeup_price,
                'groom_makeup_price' => $request->groom_makeup_price,
                'makeup_description' => $request->makeup_description,
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








    public function invitationCardDetailCreate($request)
    {


        try {

            $vendorCategoryProfile = VendorCategoryProfile::where([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ])->first();

            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'vendor_category_profile_id' => $vendorCategoryProfile->id,
                'cuisine_type' => $request->cuisine_type,
                'min_price' => $request->min_price,
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


    public function invitationCardDetailUpdate($request, $id)
    {

        try {





            DB::beginTransaction();
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where('id', $id)->update([
                'cuisine_type' => $request->cuisine_type,
                'min_price' => $request->min_price,
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

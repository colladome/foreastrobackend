<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\User;
use App\Models\Vendor\VendorGallery;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor\VendorBusinessCategoryDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor\VendorBusinessCategoryAbout;
use Illuminate\Support\Str;




class GalleryService
{

    public function create($request)
    {

        try {

            DB::beginTransaction();

            if (!empty($request->file('images'))) {

                foreach ($request->file('images') as $image) {


                    $uuid = Str::uuid()->toString();
                    $extension = $image->extension();
                    $fileName = $uuid . 'gallery';
                    $documentPath = 'gallery';
                    $filePath = $documentPath . '/' . $fileName;

                    $galleryImage = [
                        'file' =>  $filePath,
                        'extension' => $extension
                    ];

                    $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
                    VendorGallery::create([
                        'user_id' => Auth::id(),
                        'category_id' => $request->category_id,
                        'image' => $galleryImage
                    ]);
                }
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



    public function updatepdate($request, $id)
    {

        try {

            DB::beginTransaction();
            VendorBusinessCategoryAbout::where('id', $id)->update([
                'about_section' => $request->about_section,
                'is_price_negotiable' => $request->is_price_negotiable ?? 'no',
                'usp_feature' => $request->usp_feature,
                'award_and_recognition' => $request->award_and_recognition,
                'payment_policy' => $request->payment_policy,
                'cancellation_policy' => $request->cancellation_policy
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

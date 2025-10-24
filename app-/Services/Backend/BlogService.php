<?php

namespace App\Services\Backend;

use App\Exceptions\DatabaseException;
use App\Exceptions\GlobalException;
use Exception;
use App\Models\Backend\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class BlogService
{

    public function create($request)
    {



        try {


            $file = $request->file('image');


            if ($file) {
                $uuid = Str::uuid()->toString();
                $extension = $request->file('image')->extension();
                $fileName = $uuid . 'blog';
                $documentPath = 'blog';
                $filePath = $documentPath . '/' . $fileName;

                $image = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
            }


            if (empty($request->slug)) {
                $title = $request->title;
                $slug = Str::slug($title, '-');
            } else {
                $slug = $request->slug;
            }


            DB::beginTransaction();
            Blog::create([
                //'category_id' => $request->category,
                'title' => $request->title,
                'image' => $image,
                'description' => $request->description,
                'slug' => $slug,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
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
                $fileName = $uuid . 'blog';
                $documentPath = 'blog';
                $filePath = $documentPath . '/' . $fileName;

                $image = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $file->storeAs($documentPath, $fileName, 'public');
            } else {
                $categoryImage = Blog::where('id', $id)->first();

                $image = $categoryImage->image;
            }

            DB::beginTransaction();

            if (empty($request->slug)) {
                $title = $request->title;
                $slug = Str::slug($title, '-');
            } else {
                $slug = $request->slug;
            }

            Blog::where('id', $id)->update([

                // 'category_id' => $request->category,
                'title' => $request->title,
                'image' => $image,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'slug' => $slug,
                'meta_description' => $request->meta_description,
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

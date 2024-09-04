<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PublicTable\BookModel;
use App\Models\PublicTable\BookYearsModel;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class BookManageController extends Controller
{
    // -------------- add book method --------------------
    public function addBook(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $request_field = [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'book_year_id' => 'required|integer',
            'book_lang_id' => 'required|integer',
            'category_id' => 'required|integer',
            'book_stock' => 'required|integer',
            'book_image_url' => 'required||mimes:jpeg,png,jpg|max:2048'
        ];
        $validator = ReuseModule::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                BookModel::create([
                    'title' => $request->title,
                    'author' => $request->author,
                    'publisher' => $request->publisher,
                    'book_year_id' => $request->book_year_id,
                    'book_lang_id' => $request->book_lang_id,
                    'category_id' => $request->category_id,
                    'book_stock' => $request->book_stock,
                    'book_image_url' => $request->file('book_image_url')->store('puiblic/book_images')
                ]);
                $res_data['message'] = "Book has been added ";
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json(['res_data' => $res_data], 200);
    }
    // -------------- update book details -------------------
    public function updateBook(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $request_field = [
            'book_id' => 'required',
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'book_year_id' => 'required|integer',
            'book_lang_id' => 'required|integer',
            'category_id' => 'required|integer',
            'book_stock' => 'required|integer',
        ];
        $validator = ReuseModule::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $book_image_url = null;
            if ($request->file('book_image_url')) {
                $request_field = [
                    'book_image_url' => 'required||mimes:jpeg,png,jpg|max:2048'
                ];
                $validator = ReuseModule::reuseValidator($request, $request_field);
                if ($validator->fails()) {
                    $res_data['message'] = $validator->errors()->all();
                    return response()->json(['res_data' => $res_data]);
                } else {
                    $book_image_url = true;
                }
            }
            try {
                $book_id = Crypt::decryptString($request->book_id);
                $update_book_details = [
                    'title' => $request->title,
                    'author' => $request->author,
                    'publisher' => $request->publisher,
                    'book_year_id' => $request->book_year_id,
                    'book_lang_id' => $request->book_lang_id,
                    'category_id' => $request->category_id,
                    'book_stock' => $request->book_stock,
                ];
                $book_image_url ? $update_book_details['book_image_url'] = $request->file('book_image_url')->store('puiblic/book_images') : '';
                BookModel::where('id', $book_id)
                    ->update($update_book_details);
                $res_data['message'] = "Book details updated ! ";
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json(['res_data' => $res_data]);
    }
    // ------------ remove book details ----------------
    public function removeBook(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        if ($request->book_id) {
            try {
                $book_id = Crypt::decryptString($request->book_id);
                BookModel::where('id', $book_id)
                    ->delete();
                $res_data['message'] = "Book details removed !";
                $res_data['status']=200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
        } else {
            $res_data['message'] = "Book is required ";
        }
        return response()->json(['res_data' => $res_data]);
    }
    public function generateYear(Request $request)
    {
        for ($i = 1990; $i <= 2024; $i++) {
            BookYearsModel::create([
                'year' => $i
            ]);
        }
    }
}

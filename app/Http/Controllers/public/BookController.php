<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\PublicTable\BookModel;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use function PHPSTORM_META\type;

class BookController extends Controller
{
    // ------------ search and get all books -------------
    public function searchAllBooks(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $res_data['status'] = 401;
        try {
            $main_query = BookModel::query();
            $main_query->with([
                'categories' => function ($query) {
                    $query->select('id', 'category');
                },
            ]);
            if ($request->search_type == 'on_input') {
                $main_query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input_search . '%')
                        ->orWhere('author', 'like', '%' . $request->input_search . '%');
                });
            } else if ($request->search_type == 'select_search') {
                $main_query->where([
                    $request->category_id ? ['category_id', $request->category_id] : [null],
                    $request->book_year_id ? ['book_year_id', $request->book_year_id] : [null],
                    $request->book_lang_id ? ['book_lang_id', $request->book_lang_id] : [null],
                ]);
            }
            $main_query->whereHas('categories');
            $main_query->skip($request->skip ? ($request->skip * 3) : 0);
            $main_query->take(3);
            $total_pages = 0;
            $request->skip ? '' : $total_pages = $main_query->count() / 3;
            $all_books = $main_query->get();
            $res_data['total_pages'] = $total_pages;
            $res_data['all_books'] = $all_books;
            $res_data['status'] = 200;
        } catch (Exception $err) {
            // $res_data['message'] = "Server error please try later !";
            $res_data['message'] = $err->getMessage();
        }
        return response()->json(['res_data' => $res_data]);
    }
    // ------------------ view book details -------------------
    public function viewBookDetails(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        if ($request->book_id) {
            try {
                $book_id = Crypt::decryptString($request->book_id);
                $book_details = BookModel::query()->with([
                    'categories',
                    'book_years',
                    'book_languages'
                ])
                    ->where('id', $book_id)
                    ->get();
                $res_data['book_details'] = $book_details;
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
                // $res_data['message']=$err->getMessage();
            }
        } else {
            $res_data['message'] = "Book ID is required field !";
        }
        return response()->json(['res_data' => $res_data]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BorrowModel;
use App\Models\VisitorsModel;
use App\our_modules\reuse_modules\ReuseModule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    // ------------- vitisor reserve book --------------
    public function reserveBook(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $request_field = [
            'email' => 'required|email',
            'book_ids' => 'required|array'
        ];
        $validator = ReuseModule::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                $existsVisitor = VisitorsModel::where('email', $request->email)
                    ->first();
                DB::beginTransaction();
                if (!$existsVisitor) {
                    if (!$request->name) {
                        $res_data['message'] = "Name is required !";
                        $res_data['name_pop_up'] = 1;
                        return response()->json(['res_data' => $res_data]);
                    }
                    $save_visitor=VisitorsModel::create([
                        'email'=>$request->email,
                        'name'=>$request->name
                    ]);
                    $existsVisitor=$save_visitor;
                }
                $all_user = 1;
                $reserve_books_data = array_map(function ($book_id) use ($existsVisitor) {
                    return [
                        'visitor_id' => $existsVisitor->id,
                        'book_id' => $book_id,
                        'reserve_date'=>Carbon::today()->toDateString(),
                        'due_date'=> Carbon::today()->addDay(15)->toDateString()
                    ];
                }, $request->book_ids);
                BorrowModel::insert($reserve_books_data);
                DB::commit();
                $res_data['message'] = "Book is reserved !";
                $res_data['status']=200;
            } catch (Exception $err) {
                // $res_data['message'] = "Server error please try later !";
                $res_data['message']=$err->getMessage();
                DB::rollBack();
            }
        }
        return response()->json(['res_data' => $res_data]);
    }
    // ---------------- visitor borrow history -------------
    public function borrowHistory(Request $request){
        $res_data=[
            'status'=>400,
            'message'=>''
        ];
        $request_field=[
            'email'=>'required|email'
        ];
        $validator=ReuseModule::reuseValidator($request,$request_field);
        if($validator->fails()){
            $res_data['message']=$validator->errors()->all();
        }else{
            $res_data['status']=401;
            $borrow_history=VisitorsModel::query()->with([
                'borrow',
                'borrow.books'
            ])
            ->where(['email'=>$request->email])
            ->first();
            $res_data['borrow_history']=$borrow_history;
            $res_data['status']=200;
        }
        return response()->json(['res_data'=>$res_data]);
    }
}

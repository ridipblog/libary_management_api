<?php

namespace App\our_modules\reuse_modules;

use Illuminate\Support\Facades\Validator;

class ReuseModule{
     // ------------------- validation function ------------------
     public static function reuseValidator($request, $request_field)
     {
         $error_message = [
             'required' => ':attribute is required field !',
             'integer' => ':attribute is only number format !',
             'max' => ':attribute  size only 3 megabytes',
             'mimes' => ':attribute file type is not valid ',
             'email' => 'Please enter a valid email',
             'date' => ':attribute is date only '
         ];

         $validator = Validator::make(
             $request->all(),
             $request_field,
             $error_message
         );
         return $validator;
     }
}

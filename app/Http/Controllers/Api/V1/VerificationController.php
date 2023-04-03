<?php

namespace App\Http\Controllers\Api\V1;

use Response;
use Input;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\controller;
use App\Models\Verification;
use App\Http\Requests\Api\V1\verificationRequest;


class VerificationController extends Controller
{

    
    public function store(VerificationRequest $request)
    {   
        $result='Verified';        
        $issuerName=$request->input('data.issuer.name') ?? 'no data included';

        //if error is not null, get error message in $result value.
        if(!is_null($request->errors)) 
        {
            $result=$request->errors->first();
        } 

        //if user id is empty, skip insert into database.
        if(!is_null($request->input('data.id')))
        {
            $verificationData = array('user_id' => $request->input('data.id'), 'file_type' => 'JSON', 'result' => $result);
            verification::create($verificationData);  
        }

        return response()->json([
            'data' => [
                'issuer'   => $issuerName,
    
                'result'   => $result

            ]
        ]); 
    }
}

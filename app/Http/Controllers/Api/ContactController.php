<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function contact(request $request){
        try{
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:25',
        ]);

        $Contact = new Contact;
        $Contact->message = $request->message;
        $Contact->user_id = auth()->user()->id;
        $Contact->save();

        return response()->json([
            'status' => 200,
            'message' => 'Contact successfully sent',
            'Contact' => $Contact
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 500,
            'message' => $th->getMessage(),
        ], 500);
    }

    }
}

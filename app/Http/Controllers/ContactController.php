<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $contacts = Contact::latest('id')->paginate(5)->withQueryString();
        // return response()->json($contacts);

        // $contacts = Contact::when(request()->has("keyword"),function($query){
        //     $query->where(function())
        // })


        // Controlling data that u want to show using resource collection
        // return ContactResource::collection($contacts);
        // return response()->json(["message"=>"success"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "country_code" => "required|min:1|max:193",
            "phone_number" => "required",
        ]);

        $contact = Contact::create([
            "name" => $request->name,
            "country_code" => $request->country_code,
            "phone_number" => $request->phone_number,
            "user_id" => Auth::id()
            // "user_id" => $request->user_id
        ]);
        return new ContactDetailResource($contact);

    }

     /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);
        if(is_null($contact)){
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",

            ],404);
        }

        if(Gate::denies('view',$contact)){
            return response()->json([
                "message"=>"you are not allowed"
            ]);
        }

        // return response()->json([
        //     "data" => $contact
        // ]);
        return new ContactDetailResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "nullable|min:3|max:20",
            "country_code" => "nullable|integer|min:1|max:265",
            "phone_number" => "nullable|min:7|max:15"
        ]);

        $contact = Contact::find($id);
        if(is_null($contact)){
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",

            ],404);
        }

        if(Gate::denies('update',$contact)){
            return response()->json([
                "message"=>"you are not allowed"
            ]);
        }

        // $contact->update([
        //     "name" => $request->name,
        //     "country_code" => $request->country_code,
        //     "phone_number" => $request->phone_number
        // ]);

        // $contact->update($request->all());

        if($request->has('name')){
            $contact->name = $request->name;
        }

        if($request->has('country_code')){
            $contact->country_code = $request->country_code;
        }

        if($request->has('phone_number')){
            $contact->phone_number = $request->phone_number;
        }

        $contact->update();



        return new ContactDetailResource($contact);
    }

    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        if(is_null($contact)){
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",

            ],404);
        }
        $contact->delete();


        if(Gate::denies('delete',$contact)){
            return response()->json([
                "message"=>"you are not allowed"
            ]);
        }
        // return response()->json([],204);
        return response()->json([
            "message" => "Contact is deleted",
        ]);
    }


}

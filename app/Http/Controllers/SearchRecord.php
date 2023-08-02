<?php

namespace App\Http\Controllers;

use App\Models\SearchRecord as ModelsSearchRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchRecord extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                "keyword"=>"required"
            ]
        );
        // $keyword = $request->keyword;

        // return response()->json([
        //     "search_records"=>$keyword
        // ]);

        $search = ModelsSearchRecord::create([
            "keyword"=>$request->keyword,
           
        ]);

        return response()->json([
            "search_records"=> $search
        ]);

    }

    public function destroy(string $id)
    {
        $search = ModelsSearchRecord::find($id);
        if(is_null($search)){
            return response()->json([
                // "success" => false,
                "message" => "Search Record not found",

            ],404);
        }

        $search->delete();

    }
}

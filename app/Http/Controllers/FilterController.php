<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Filter;
use Auth;

class FilterController extends Controller
{
    public function getFilters() {

        return response()->json([
            'data' => [
                'categories' => Filter::where('type', 'category')
                ->where('user_id', Auth::user()->id)
                ->get(),
                'sources' => Filter::where('type', 'source')
                ->where('user_id', Auth::user()->id)
                ->get(),
                'authors' => Filter::where('type', 'author')
                ->where('user_id', Auth::user()->id)
                ->get()
            ]
        ], 200);
        
    }

    public function store(Request $req) {

        if (!$req->type || !$req->name) {
            return response()->json(['error' => 'Invalid Parameters'], 400);
        }

        $countFilters = Filter::where('type', $req->type)
        ->where('user_id', Auth::user()->id)
        ->count();

        if ($countFilters >= 10) {
            return response()->json([
                'message' => 'Limit of 10 reached'
            ], 422);
        }

        try {

            $filter = User::find(Auth::user()->id)->filters()->create([
                'type' => $req->type,
                'name' => $req->name
            ]);


            return response()->json([
                'data' => [
                    'filter' => $filter
                ],
                'message' => 'Filter Created'
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {


        try {
            $filter = Filter::find($id);

            $filter->delete();

            return response()->json([
                'data' => [
                    'filter' => $filter
                ],
                'message' => 'Filter Deleted'
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

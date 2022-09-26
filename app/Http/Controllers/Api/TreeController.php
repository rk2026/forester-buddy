<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Species;
use App\Tree;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TreeController extends Controller
{
    public function getAllSpecies(Request $request)
    {
        $species = Species::all();
        return response()->json(["message" => "All species fetched successfully", "data" => $species]);
    }

    public function getAllTrees(Request $request)
    {
        $trees = Tree::all();
        return response()->json(["message" => "All tree data fetched successfully", "data" => $trees]);
    }

    public function addTree(Request $request)
    {
        foreach ($request as $data) {
            $tree = new Tree();
            $tree->user_id = 1;
            $tree->species_id = $data->species_id;
            $tree->upload_id = 'file_' . date('m-d-Y_hia');
            $tree->chapan_no = $data->chapan_no;
            $tree->latitude = $data->latitude;
            $tree->longitude = $data->longitude;
            $tree->girth_cm = $data->girth_cm;
            $tree->height_m = $data->height_m;
            $tree->class = $data->class;
            $tree->save();
        }

        return response()->json(["message" => "File uploaded successfully"]);
    }
}

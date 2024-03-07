<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssociationCommittes;

class AssociationsCommittesController extends Controller
{
    public function index()
    {
        $associations = AssociationCommittes::all();
        return view('frontend.pages.association_committees.all', compact('associations'));
    }
    public function associationDetails($id)
    {
        $association = AssociationCommittes::findOrFail($id);
        if ($association) {
            return view('frontend.pages.association_committees.details', compact('association'));
        }
    }
}

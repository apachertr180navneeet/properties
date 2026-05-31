<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('salesPerson')->where('status', 'available');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('city', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhere('property_type', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('type')) {
            $query->where('property_type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('property_category', $request->category);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $properties = $query->orderBy('id', 'desc')->paginate($request->get('limit', 9))->withQueryString();

        $cities = Property::distinct()->whereNotNull('city')->pluck('city');
        $types = Property::distinct()->whereNotNull('property_type')->pluck('property_type');
        $categories = Property::distinct()->whereNotNull('property_category')->pluck('property_category');

        return view('web.home.index', compact('properties', 'cities', 'types', 'categories'));
    }

    public function show($id)
    {
        $property = Property::with('salesPerson')->findOrFail($id);
        $relatedProperties = Property::with('salesPerson')->where('id', '!=', $id)->where('status', 'available')->limit(4)->get();

        return view('web.properties.show', compact('property', 'relatedProperties'));
    }
}

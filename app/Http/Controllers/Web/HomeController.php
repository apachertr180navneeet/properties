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

    // New methods for roofing company pages
    public function about()
    {
        return view('web.about');
    }

    public function services()
    {
        return view('web.services');
    }

    public function servicesCarousel()
    {
        return view('web.services-carousel');
    }

    public function singlePlayRoofing()
    {
        return view('web.single-play-roofing');
    }

    public function modifiedRoofing()
    {
        return view('web.modified-roofing');
    }

    public function builtUpRoofing()
    {
        return view('web.built-up-roofing');
    }

    public function roofInspection()
    {
        return view('web.roof-inspection');
    }

    public function roofInstallation()
    {
        return view('web.roof-installation');
    }

    public function metalRoofing()
    {
        return view('web.metal-roofing');
    }

    public function team()
    {
        return view('web.team');
    }

    public function teamCarousel()
    {
        return view('web.team-carousel');
    }

    public function teamDetails($id)
    {
        return view('web.team-details');
    }

    public function testimonials()
    {
        return view('web.testimonials');
    }

    public function testimonialsCarousel()
    {
        return view('web.testimonials-carousel');
    }

    public function gallery()
    {
        return view('web.gallery');
    }

    public function galleryCarousel()
    {
        return view('web.gallery-carousel');
    }

    public function faq()
    {
        return view('web.faq');
    }

    public function notFound()
    {
        return view('web.404');
    }

    public function work()
    {
        return view('web.work');
    }

    public function workCarousel()
    {
        return view('web.work-carousel');
    }

    public function workDetails($id)
    {
        return view('web.work-details');
    }

    public function blog()
    {
        return view('web.blog');
    }

    public function blogCarousel()
    {
        return view('web.blog-carousel');
    }

    public function blogSidebar()
    {
        return view('web.blog-sidebar');
    }

    public function blogDetails($id)
    {
        return view('web.blog-details');
    }

    public function contact()
    {
        return view('web.contact');
    }
}


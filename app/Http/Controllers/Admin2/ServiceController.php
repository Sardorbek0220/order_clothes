<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service_category;
use App\Models\Service;
use App\Models\Status;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($language)
    {
        $services = Service::where('status_id', '!=', 4)->get();        
        return view('admin2.service.index', compact('services', 'language'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($language)
    {
        $categories = Service_category::where('status_id', 1)->get();
        return view('admin2.service.create', compact('categories', 'language'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $language)
    {
        $request->validate([
            'name'=>'required',
            'name_ru'=>'required',
            'name_en'=>'required',
            'price'=>'required',
            'service_cat_id'=>'required',
            'photo'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $folder = date('Y-m-d');
            $avatar = $request->file('img')->store("images/{$folder}");
        }else{
            $avatar = '';
        }

        $service = Service::create([
            'name' => $request->name,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'photo' => $avatar,
            'price' => $request->price,
            'service_cat_id' => $request->service_cat_id,
            'status_id' => 1
        ]);
        return redirect()->route('services.index', app()->getLocale());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id)
    {
        $statuses = Status::get();
        $categories = Service_category::get();
        $service = Service::find($id);
        return view('admin2.service.edit', compact('service', 'categories', 'statuses', 'language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language, $id)
    {
        $request->validate([
            'name'=>'required',
            'name_ru'=>'required',
            'name_en'=>'required',
            'price'=>'required',
            'service_cat_id'=>'required',
            'status_id'=>'required',
            'photo'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $folder = date('Y-m-d');
            $avatar = $request->file('img')->store("images/{$folder}", 'public');
        }else{
            $avatar = $request->own_img;
        };

        $service = Service::find($id);
        $service->update([
            'name' => $request->name,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'service_cat_id' => $request->service_cat_id,
            'status_id' => $request->status_id,
            'photo' => $avatar
        ]);

        return redirect()->route('services.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $id)
    {
        $service = Service::find($id);
        $service->update([
            'status_id' => 4
        ]);

        return redirect()->route('services.index', app()->getLocale());
    }
}

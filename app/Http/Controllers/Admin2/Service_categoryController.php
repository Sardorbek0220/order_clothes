<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service_category;
use App\Models\Status;

class Service_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($language)
    {
        $cats = Service_category::where('status_id', '!=', 4)->get();        
        return view('admin2.serv_cat.index', compact('cats', 'language'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($language)
    {
        return view('admin2.serv_cat.create', compact('language'));
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
            'photo'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $folder = date('Y-m-d');
            $avatar = $request->file('img')->store("images/{$folder}", 'public');
        }else{
            $avatar = '';
        }

        $category = Service_category::create([
            'name' => $request->name,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'photo' => $avatar,
            'status_id' => 1
        ]);
        return redirect()->route('categories.index', app()->getLocale());
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
        $category = Service_category::find($id);
        return view('admin2.serv_cat.edit', compact('category', 'statuses', 'language'));
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
            'status_id'=>'required',
            'photo'=>'nullable|image'
        ]);

        if ($request->hasFile('img')) {
            $folder = date('Y-m-d');
            $avatar = $request->file('img')->store("images/{$folder}", 'public');
        }else{
            $avatar = $request->own_img;
        };

        $category = Service_category::find($id);
        $category->update([
            'name' => $request->name,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'status_id' => $request->status_id,
            'photo' => $avatar
        ]);

        return redirect()->route('categories.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $id)
    {
        $category = Service_category::find($id);
        $category->update([
            'status_id' => 4
        ]);

        return redirect()->route('categories.index', app()->getLocale());
    }
}

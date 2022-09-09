<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections', [
           'sections' =>  $sections  ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('sections.sections');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
       $validation = $request->validated();
      $data = $request->all();
      $data['created_by'] = Auth::user()->name;
       Section::create($data);

       return redirect()->route('section.list')
       ->with('success' , 'Success Added');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
       return view('sections.sections' , [
        'sectionl' =>$section
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        //$validation = $request->validated();
        $request->validate([
          //  'section_name' => 'required|max:50|unique:sections,section_name,'.$id ,
           'section_name' => ['required' , 'max:50' , 'unique:sections,section_name,'.$id],
            'description' => 'required' , 
        ]);
        $section = Section::findOrFail($id);
       // $data = $request->except('section_name');
        $data = $request->all();
        $section->update($data);

        return redirect()->route('section.list')
        ->with('success' , 'Success Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(Section $section)
    {
        //
    }
    */

    public function destroy(Request $request)
    {
        $id = $request->id;
        $section = Section::findOrFail($id);
        $section->delete();
        return redirect()->route('section.list')
        ->with('success' , 'Success deleted');
    }
}

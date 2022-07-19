<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public  function  view_file($invoice_number , $file_name){

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->except('file_name');
        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $data['Created_by'] = Auth::user()->name;
        $data['file_name'] = $file_name;
        invoice_attachment::create($data);

       // $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $file_name);


        session()->flash('Add', 'success Added');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachment $invoice_attachment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachment $invoice_attachment)
    {
        //
    }
}

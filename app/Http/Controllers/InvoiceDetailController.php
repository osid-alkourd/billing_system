<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\invoice_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $invoice = Invoice::where('id' , $id)->first();
        $details = invoice_detail::where('invoice_id' , $id)->get();
        $attachments = invoice_attachment::where('invoice_id' , $id)->get();

        return view('invoices.invoice_details', [
            'invoice' => $invoice  ,
            'details' => $details  ,
            'attachments' =>  $attachments ,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_detail $invoice_detail)
    {
        //
    }

    public  function  view_file($invoice_number , $file_name){

        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($file);
    }

    public function download_file($invoice_number , $file_name){

        $file= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice_attachment = invoice_attachment::findOrFail($request->file_id);
        $invoice_attachment->delete();
        $file= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete' , 'success deleted');
        return back();

    }
}

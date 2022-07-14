<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\Product;
use App\Models\Section;
use App\Models\invoice_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices' , [
            'invoices' => $invoices ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice',[
            'sections' => $sections ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data1 = $request->except('Section');
        $data1['section_id'] = $request->input('Section');
        $data1['Status'] = 'not paid';
        $data1['Value_Status'] = 2; // not paid


        Invoice::create($data1);

       $invoice_id = Invoice::latest()->first()->id;

        $data2 = $request->only('invoice_number' , 'product' , 'note');
        $data2['section_id'] = $request->input('Section');
        $data2['invoice_id'] =  $invoice_id ;
        $data2['Status'] =  'Not Paid' ;
        $data2['Value_Status'] = 2; // not paid
        $data2['created_by'] = Auth::user()->name;

        invoice_detail::create($data2);


        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $data3 = $request->only('invoice_number');
            $data3['invoice_id'] =  $invoice_id ;
            $data3['Created_by'] = Auth::user()->name;

            $image = $request->file('pic');
            $data3['file_name'] = $image->getClientOriginalName();

            invoice_attachment::create($data3);

            $request->pic->move(public_path('Attachments/' .  $data3['invoice_number']), $data3['file_name']);
        }

        return redirect()->route('invoice.create')->
        with('success' , 'Invoices Success Added');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }


    public function getProducts($id)
    {
        $products = Product::where("section_id", $id)->pluck("product_name", "id");
        return response()->json($products);
    }

}

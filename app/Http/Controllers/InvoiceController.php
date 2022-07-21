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
use Illuminate\Support\Facades\Storage;

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
        $data_invoice = $request->except('Section');
        $data_invoice['section_id'] = $request->input('Section');
        $data_invoice['Status'] = 'not paid';
        $data_invoice['Value_Status'] = 2; // not paid Invoice


        Invoice::create( $data_invoice);

       $invoice_id = Invoice::latest()->first()->id;

        $data_invoice_details = $request->only('invoice_number' , 'product' , 'note');
        $data_invoice_details['section_id'] = $request->input('Section');
        $data_invoice_details['invoice_id'] =  $invoice_id ;
        $data_invoice_details['Status'] =  'Not Paid' ;
        $data_invoice_details['Value_Status'] = 2; // not paid
        $data_invoice_details['created_by'] = Auth::user()->name;

        invoice_detail::create($data_invoice_details);


        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $data_invoice_attachment= $request->only('invoice_number');
            $data_invoice_attachment['invoice_id'] =  $invoice_id ;
            $data_invoice_attachment['Created_by'] = Auth::user()->name;

            $image = $request->file('pic');
            $data_invoice_attachment['file_name'] = $image->getClientOriginalName();

            invoice_attachment::create($data_invoice_attachment);

            $request->pic->move(public_path('Attachments/' .  $data_invoice_attachment['invoice_number']), $data_invoice_attachment['file_name']);
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
        $sections = Section::all();
        return view('invoices.invoice_edit' , [
            'invoice' => $invoice ,
            'sections' =>$sections ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // invoice id
        $invoice_id = $request->invoice_id;
       // $invoice_number = $request->input('invoice_number');
        // update invoice table
        $data_invoice = $request->except('Section');
        $data_invoice['section_id'] = $request->input('Section');
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice->update($data_invoice);

        // update invoice_details table
        $data_invoice_details = $request->only('invoice_number' , 'product' , 'note' , 'invoive_id');
        $data_invoice_details['section_id'] = $request->input('Section');
        $data_invoice_details['Status'] =  'Not Paid' ;
        $data_invoice_details['Value_Status'] = 2; // not paid
        $data_invoice_details['created_by'] = Auth::user()->name;
        invoice_detail::where('invoice_id' ,$invoice_id )->update($data_invoice_details);


        // update invoice_attachment
        invoice_attachment::where('invoice_id' ,$invoice_id )->update([
            'invoice_number' =>$request->input('invoice_number')
        ]);





        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $id = $request->invoice_id;
        $invoice = Invoice::where('id', $id)->first();
        $Details = invoice_attachment::where('invoice_id', $id)->get();

        foreach ($Details as $detail){
            Storage::disk('public_uploads')->deleteDirectory($detail->invoice_number);
        }
        $invoice->forceDelete();
       // return redirect()->route('invoices')

        return redirect()->route('invoice.list')
            ->with('delete_invoice' , 'success Deleted Invoice');

    }


    public function getProducts($id)
    {
        $products = Product::where("section_id", $id)->pluck("product_name", "id");
        return response()->json($products);
    }

}

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

    // show status payment for invoice
    public function showStatusPayment(Invoice $invoice){
        return view('invoices.status_payment_update' , [
            'invoice' => $invoice ,
        ]);
    }

    // to update invoice status payment
    public function updateStatusPayment(Request $request , Invoice $invoice)
    {

        if ($request->Status === 'paid') {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
            ]);

           // $invoice_details_data = $request->all();
         //   $invoice_details_data['Value_Status'] = 1;
            invoice_detail::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number ,
                'product' => $invoice->product ,
                'section_id' => $invoice->section_id ,
                'Status' => $request->Status ,
                'Value_Status' => 1 ,
                'Payment_Date' => $request->Payment_Date,
                'note' => $invoice->note ,
                'created_by' => Auth::user()->name ,
            ]);

          return redirect()->route('invoice.show' , $invoice->id)
              ->with('successChange' , 'The Invoice Are Paid Now');

        } else if($request->Status === 'Partially paid'){
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoice_detail::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number ,
                'product' => $invoice->product ,
                'section_id' => $invoice->section_id ,
                'Status' => $request->Status ,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
                'note' => $invoice->note ,
                'created_by' => Auth::user()->name ,
            ]);

            return redirect()->route('invoice.show' , $invoice->id)
                ->with('successChange' , 'The Invoice Are Partially paid Now');

        }
        else {
            return redirect()->route('invoice.status_payment_show' , $invoice->id)
                ->with('successChange' , 'Not selected status Payment');

        }

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
        $detail = invoice_attachment::where('invoice_id', $id)->first();
        Storage::disk('public_uploads')->deleteDirectory($detail->invoice_number);

        /*
        foreach ($Details as $detail){
            Storage::disk('public_uploads')->deleteDirectory($detail->invoice_number);
        }
        */
        $invoice->forceDelete(); // delete it from database too
       // return redirect()->route('invoices')

        return redirect()->route('invoice.list')
            ->with('delete_invoice' , 'success Deleted Invoice');

    }

   public function paid_invoices(){
      //  return $request;
       $paid_invoices = Invoice::where('Value_Status' , 1)->get();
       return view('invoices.paid_invoices' , compact('paid_invoices'));
   }

   public function unpaid_invoices(){
        $unpaid_invoices = Invoice::where('Value_Status' , 2)->get();
        return view('invoices.unpaid_invoices' , compact('unpaid_invoices'));
   }

    public function partially_paid_invoices(){
       $partially_paid_invoices = Invoice::where('Value_Status' , 3)->get();
       return view('invoices.partially_paid_invoices' , compact('partially_paid_invoices'));
    }

    public function archive_invoice(Request $request){


        $invoice = Invoice::where('id' , $request->invoice_id)->first();
        $invoice->delete();
        //session()->flash('archive_invoice');
        return redirect()->route('invoice.list')->with('archive_invoice' , 'success archive invoice');


       // return $request;


    }

    // print invoice as a pdf 

    public function print_invoice($id){
        $invoice = Invoice::findOrFail($id);
        
        return view('invoices.print_invoice' , [
            'invoice' => $invoice  ,
        ]);
    }

    public function getProducts($id)
    {
        $products = Product::where("section_id", $id)->pluck("product_name", "id");
        return response()->json($products);
    }



}

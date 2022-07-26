<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Archived_invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive_invoices' , compact('Archived_invoices'));
    }





    public function update(Request $request)
    {
        $invoice_id = $request->invoice_id;
        Invoice::withTrashed()->where('id' , $invoice_id)->restore();
        return redirect()->route('Archived_invoices.list')
            ->with('restore_invoice' , 'invoice has been successfuly restore');
    }

    
    public function destroy(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice =  Invoice::withTrashed()->where('id' , $invoice_id)->first();
        $invoice->forceDelete();

        return redirect()->route('Archived_invoices.list')
            ->with('delete_invoice', 'success deleted');
    }
}

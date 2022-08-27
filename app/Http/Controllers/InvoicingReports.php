<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
class InvoicingReports extends Controller
{
    
    public function index(){
        return view('reports.invoicing_reports');
    }

    public function search_an_invoice(Request $request){

        $rdio  = $request->rdio;
       // $invoices = '';
        // if $rdio = 1 then search by using invoice type
        // if $rdio = 2 then search by using invoice number

        
        if($rdio == 1){
            // type of invoice where 1 is paid invocie , 2 unpaid invoice and 3 partially paid invocie
            $type = $request->type;
            $start = $request->start_at;
            $end = $request->end_at;
            
            // if the user do not select type
            if($type == ''){

               return back();
            }
            // if the user did not select start_at or end_at
            else if($start == '' || $end == '') {
                $invoices = Invoice::where('Status' , $type)->get();
                return view('reports.invoicing_reports' , compact('type' , 'invoices'));
            }
            // if user selected the start_at and end_at and type
            else {
                $invoices = Invoice::whereBetween('invoice_Date' , [$start, $end])
                  ->where('Status' , $type);
                  return view('reports.invoicing_reports' , compact('type' , 'invoices'));
            }  
            
        }
        else if($rdio == 2){
            // is user did not send a invoice number
            if($request->invoice_number == ''){
                return back();
            }
                        // is user  sent a invoice number

            $invoices = Invoice::where('invoice_number' , $request->invoice_number)->get();
            return view('reports.invoicing_reports' , compact('invoices'));       
        
        }
        // if rdio did not select
        else {
            return back();
        }
        
        










        /*
        if($rdio == 1){
            $type = $request->type;
            if($request->start_at == '' || $request->end_at == ''){
                $start = date($request->start_at);
                $end = date($request->end_at);
                $invoices = Invoice::whereBetween('invoice_Date' , [$start , $end])
                ->where('Value_Status' , $type)->get();
                return view('reports.invoicing_reports' , compact('start' , 'end'))->withDetails($invoices);

            }else {
                $invoices = Invoice::where('Value_Status' , $type)->get();
                return view('reports.invoicing_reports' , compact('type'))->withDetails($invoices);
            }   
        }
        else if($rdio == 2){
            $invoices = Invoice::where('invoice_number' , $request->invoice_number)->get();
            return view('reports.invoicing_reports')->withDetails($invoices);;

        }
        else{

        }

        */


    }
}

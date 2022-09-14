@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    اضافة فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('Add Invoice') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
   @endif
        @if ($errors->any())
        <div class="alert alert-danger">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
           
        </div>
       @endif    
        
     <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('Invoice Number') }}</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" required>
                            </div>

                            <div class="col">
                                <label>{{ __('Invoice Date') }} </label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label> {{ __('due date') }} </label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled> {{ __('Select Section') }}</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('Product') }}</label>
                                <select id="product" name="product" class="form-control">
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('Amount_collection') }} </label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection">
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('Commission_amount') }}</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                    name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "    required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('Discount') }}</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                    title="يرجي ادخال مبلغ الخصم "
                                    value=0 required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> {{ __('tax_rate') }}</label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="calculateTotal()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    @foreach ($taxes as $tax => $value )
                                        <option value="{{$value }}">{{$tax}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">{{ __('tax_value') }} </label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

    <script>
        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) { // this function executed when request succeeds
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });

    </script>


    <script>
        function calculateTotal() {

            var commissionAmount = parseFloat(document.getElementById("Amount_Commission").value);
            var discount = parseFloat(document.getElementById("Discount").value);
            var rate_vat = parseFloat(document.getElementById("Rate_VAT").value);
            var value_vat = parseFloat(document.getElementById("Value_VAT").value);
            var commissionAmount_after_discount = commissionAmount - discount;
            var taxValue = parseFloat(commissionAmount_after_discount * rate_vat / 100); // tax value
            var total_including_tax = parseFloat(taxValue + commissionAmount_after_discount); // tax value + commiction ammount after discount
            document.getElementById("Value_VAT").value = taxValue; // tax value
            document.getElementById("Total").value = total_including_tax;

            /*
            if (typeof commissionAmount === 'undefined' || !commissionAmount) {

                alert('يرجي ادخال مبلغ العمولة ');

            } else {
                var taxValue = parseFloat(commissionAmount_after_discount * rate_vat / 100); // tax value
                var total_including_tax = parseFloat(taxValue + commissionAmount_after_discount); // tax value + commiction ammount after discount
                document.getElementById("Value_VAT").value = taxValue; // tax value
                document.getElementById("Total").value = total_including_tax;

            }
            */

        }
/*
        var intResults = commissionAmount_after_discount * rate_vat / 100; // tax value

                var intResults2 = parseFloat(intResults + commissionAmount_after_discount); // tax value + commiction ammount after discount

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("Value_VAT").value = sumq; // tax value

                document.getElementById("Total").value = sumt;
*/
    </script>


@endsection

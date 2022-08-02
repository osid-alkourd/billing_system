@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{__('invoice details')}}@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Invoicing list')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{__('invoice details')}}  </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('successChange'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('successChange') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">
                                                {{__('Invoice information')}}    </a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">{{__('Payment statuses')}}</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">{{__('attachments')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">{{__('Invoice Number')}}</th>
                                                        <td>{{ $invoice->invoice_number }}</td>
                                                        <th scope="row">{{__('Invoice Date')}}</th>
                                                        <td>{{ $invoice->invoice_Date }}</td>
                                                        <th scope="row">{{__('due date')}}</th>
                                                        <td>{{ $invoice->Due_date }}</td>
                                                        <th scope="row">{{__('Section')}}</th>
                                                        <td>{{ $invoice->section->section_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">{{__('Product')}}</th>
                                                        <td>{{ $invoice->product }}</td>
                                                        <th scope="row">{{__('Amount_collection')}}</th>
                                                        <td>{{ $invoice->Amount_collection }}</td>
                                                        <th scope="row">{{__('Commission_amount')}}</th>
                                                        <td>{{ $invoice->Amount_Commission }}</td>
                                                        <th scope="row">{{__('Discount')}}</th>
                                                        <td>{{ $invoice->Discount }}</td>
                                                    </tr>


                                                    <tr>
                                                        <th scope="row"> {{__('tax_rate')}}</th>
                                                        <td>{{ $invoice->Rate_VAT }}</td>
                                                        <th scope="row">{{__('tax_value')}}</th>
                                                        <td>{{ $invoice->Value_VAT }}</td>
                                                        <th scope="row">{{__('Total')}}</th>
                                                        <td>{{ $invoice->Total }}</td>
                                                        <th scope="row">{{__('current statuse')}}</th>

                                                        @if ($invoice->Value_Status == 1)
                                                            <td><span
                                                                    class="badge badge-pill badge-success">{{ $invoice->Status }}</span>
                                                            </td>
                                                        @elseif($invoice->Value_Status ==2)
                                                            <td><span
                                                                    class="badge badge-pill badge-danger">{{$invoice->Status }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge badge-pill badge-warning">{{ $invoice->Status }}</span>
                                                            </td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">{{__("Notes")}}</th>
                                                        <td>{{ $invoice->note }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                       style="text-align:center">
                                                    <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>{{__('Invoice Number')}}</th>
                                                        <th>{{__('Product type')}}</th>
                                                        <th>{{__('Section')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Payment Date')}} </th>
                                                        <th>{{__('Notes')}}</th>
                                                        <th>{{__('Invoice Date')}} </th>
                                                        <th>{{__('user')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                     {{$i = 0}}
                                                    @foreach ($details as $detail)
                                                         {{$i++}}
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $detail->invoice_number }}</td>
                                                            <td>{{ $detail->product }}</td>
                                                            <td>{{ $detail->section->section_name }}</td>
                                                            @if ($detail->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $detail->Status }}</span>
                                                                </td>
                                                            @elseif($detail->Value_Status ==2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $detail->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $detail->Status }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ $detail->Payment_Date }}</td>
                                                            <td>{{$detail->note }}</td>
                                                            <td>{{ $detail->created_at }}</td>
                                                            <td>{{ $detail->created_by }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">

                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">{{__('Add attachments')}}</h5>
                                                    <form method="post" action="{{route('invoice.add_file')}}"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="file_name"
                                                                   name="file_name" required>
                                                            <input type="hidden" id="invoice_number" name="invoice_number"
                                                                   value="{{ $invoice->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                   value="{{ $invoice->id }}">
                                                            <label class="custom-file-label" for="file_name">
                                                              {{__('Select Section')}}</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">{{__('Confirm')}}</button>
                                                    </form>
                                                </div>
                                                <br>

                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                           style="text-align:center">
                                                        <thead>
                                                        <tr class="text-dark">
                                                            <th scope="col">م</th>
                                                            <th scope="col">{{__('file name')}}</th>
                                                            <th scope="col">{{__('user')}} </th>
                                                            <th scope="col">{{__('Invoice Date')}}</th>
                                                            <th scope="col">{{__('Operations')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($attachments as $attachment)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $attachment->file_name }}</td>
                                                                <td>{{ $attachment->Created_by }}</td>
                                                                <td>{{ $attachment->created_at }}</td>
                                                                <td colspan="2">

                                                                    <a class="btn btn-outline-success btn-sm"
                                                                       href="{{route('invoice.view_file' , [$invoice->invoice_number ,$attachment->file_name] )}}"
                                                                       role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                        عرض</a>

                                                                    <a class="btn btn-outline-info btn-sm"
                                                                       href="{{route('invoice.download_file' , [$invoice->invoice_number ,$attachment->file_name] )}}"
                                                                       role="button"><i
                                                                            class="fas fa-download"></i>&nbsp;
                                                                        {{__('Download')}}</a>


                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                data-file_id="{{ $attachment->id }}"
                                                                                data-target="#delete_file">{{__('Delete')}}</button>


                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        </tbody>
                                                    </table>

                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /div -->
        </div>

    </div>
    <!-- /row -->

    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('delete attachment')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('invoice.destroy_file') }}" method="post">

                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red">{{__('Are you sure to delete the attachment?')}}</h6>
                        </p>

                        <input type="hidden" name="file_id" id="file_id" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancle')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var file_id = button.data('file_id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #file_id').val(file_id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>

    <script>

    </script>

@endsection

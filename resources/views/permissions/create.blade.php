@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    @section('title')
         {{__('Add Permission')}}
    @stop

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('permissions')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Add')}}
                    {{__('permissions')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{__('error')}}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




    {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                                <p>{{__('Permissions Name')}} :</p>
                                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                               <span>{{__('is_parent')}}: </span> &nbsp;
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="is_parent" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customRadioInline1">{{ __('Yes') }}</label>
                                </div>
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="is_parent" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="customRadioInline2">{{ __('No') }}</label>
                                 </div>
                            </div>
                        </div>

                    <br><br>
                 <div class="col-xs-7 col-sm-7 col-md-7">
                    <div class="form-group">
                        <p>{{ __('Choice Parent') }}</p>
                        <select name="parent_id" class="custom-select custom-select-sm" >
                            $parent
                           @foreach ( $permissions as $permission )
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>   
                    
                    <div class="row">
                        <!-- col -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">{{__('Confirm')}}</button>
                        </div>
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

    {!! Form::close() !!}
@endsection
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection

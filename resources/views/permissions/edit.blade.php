@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    @section('title')
        {{__('update roles')}}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('permissions')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('permissions')}}
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


    {!! Form::model( $permission, ['method' => 'PATCH','route' => ['permissions.update',  $permission->id]]) !!}
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="form-group">
                            <p>{{__('permission name')}} :</p>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                               <span>{{__('is_parent')}}: </span> &nbsp;
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" 
                                    name="is_parent" class="custom-control-input" value="1" {{ $permission->is_parent == 1 ? 'checked' : ''  }}>
                                    <label class="custom-control-label" for="customRadioInline1">{{ __('Yes') }}</label>
                                </div>
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="is_parent" class="custom-control-input" value="0"  {{ $permission->is_parent == 0 ? 'checked' : ''  }}>
                                    <label class="custom-control-label" for="customRadioInline2">{{ __('No') }}</label>
                                 </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="col-xs-7 col-sm-7 col-md-7">
                           <div class="form-group">
                               <p>{{ __('Choice Parent') }}</p>
                               <select name="parent_id" class="custom-select custom-select-sm" >
                                  <option value="" selected disabled></option>
                                   @foreach ($parents as $parent)
                                      <option value="{{ $parent->id }}" {{$parent->id == $permission->parent_id ? 'selected' : '' }}>{{ $parent->name}}</option> 
                                   @endforeach
                               </select>
                           </div>
                       </div>   

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">{{__('update')}}</button>
                        </div>
                        <!-- /col -->
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

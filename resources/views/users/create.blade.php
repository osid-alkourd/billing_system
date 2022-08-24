@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    @section('title')
       {{__('add users')}}
    @stop


@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('add')}}
                {{__('user')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">


        <div class="col-lg-12 col-md-12">

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

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">{{__('back')}}</a>
                        </div>
                    </div><br>
                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                          action="{{route('users.store')}}" method="post">
                            @csrf

                        <div class="">

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>{{__('user name')}}: <span class="tx-danger">*</span></label>
                                    <input class="form-control form-control-sm mg-b-20"
                                           data-parsley-class-handler="#lnWrapper" name="name"  type="text">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{__('email')}}: <span class="tx-danger">*</span></label>
                                    <input class="form-control form-control-sm mg-b-20"
                                           data-parsley-class-handler="#lnWrapper" name="email" type="email">
                                </div>
                            </div>

                        </div>

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('password')}}: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                       name="password" type="password">
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('confirm password')}}: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                       name="confirm-password"  type="password">
                            </div>
                        </div>

                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <label class="form-label">{{__('user status')}}</label>
                                <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="active">{{__('active')}}</option>
                                    <option value="not active">{{__('not active')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label"> {{__('user roles')}}</label>
                                    {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                </div>
                            </div>
                        </div>

                    <div class="row mg-b-20">
                        <div class="form-check">
                            <p class="font-weight-bold"> {{__('user Permissions')}}</p>
                            <div>
                              <ul>
                               @foreach ($parent_permissions as $parent_permission)
                               {{--   @if($permission->parent_id == null)--}}
                               
                                <li id='parenPermissions_id'> {{ $parent_permission->name }} 	&nbsp; 	&nbsp; 	&nbsp; 	 <input class="form-check-input parent" type="checkbox" name="user_permissions[]" value="{{$parent_permission->id }}"> &nbsp; </li>
                                <ul>
                                     <br>
                                     @foreach ($permissions as $permission)
                                         @if($permission->parent_id == $parent_permission->id )
                                         <li> {{$permission->name }} 	&nbsp; 	&nbsp; 	&nbsp; 	 <input class="form-check-input child" type="checkbox" name="user_permissions[]" value="{{$permission->id }}"   data-parentPermission="{{ $parent_permission->id  }}"  id="flexCheckChecked"> &nbsp; </li>
                                         <br>
                                         @endif
                                     @endforeach
                                     <br><br>
                                </ul>
                               @endforeach
                              </ul>   
                            </div>
                      </div>
                    </div>  
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">{{__('Confirm')}}</button>
                        </div>
                    </form>
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


    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
    <script>
      $('input.parent').on('change', function(){
        var id = $(this).val();
        if($(this).is(':checked')){
            $('.child[data-parentPermission |="'+id+'"]').attr('checked', true);
        }else{
            $('.child[data-parentPermission |="'+id+'"]').attr('checked', false);
        }
        })
    </script>
@endsection

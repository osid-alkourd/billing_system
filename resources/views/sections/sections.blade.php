@extends('layouts.master')

@section('title')
    Section Dashboard
@endsection

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Setting</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Sections</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
				@endif


				@if($errors->any())
                      <div  class="alert alert-danger">
						  
						<ul>
							@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					  
					 </div>  
				@endif


				<div class="row">

					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">Add Section</a>								
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">Section Name </th>
												<th class="border-bottom-0">Notes</th>
												<th class="border-bottom-0">Operations</th>
												

											</tr>
										</thead>
										<tbody>		
											<?php $i = 0; ?>
											@foreach ($sections as $section )
				                                {{ $i++ }}
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $section->section_name }}</td>
												<td>{{ $section->description}}</td>
												
												<td>

                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                       data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}"
                                                       data-description="{{ $section->description}}" data-toggle="modal" href="#exampleModal2"
                                                       title="Update"><i class="las la-pen"></i></a>

                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                       data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}" data-toggle="modal"
                                                       href="#modaldemo9" title="delete"><i class="las la-trash"></i></a>

                                               </td>
											</tr>

										  @endforeach		
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal" id="modaldemo8">
					<div class="modal-dialog" role="document">
						<div class="modal-content modal-content-demo">
							<div class="modal-header">
								<h6 class="modal-title">Add Section</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
							 <form action="{{ route('section.store')}}" method="post">
								@csrf	
								<div class="form-group" style="text-align: left;">
									<label for="section_name" >Section Name</label>
									<input type="text" class="form-control" id="section_name" name="section_name">
								</div>

								<div class="mb-3" style="text-align: left;">
									<label for="description" class="form-label">Any Notes</label>
									<textarea class="form-control" id="description" name="description" rows="3"></textarea>
								</div>
								<div class="modal-footer">
									<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
									<button class="btn ripple btn-primary" type="submit">Submit</button>

								</div>
						     </form> 
							</div>
							
						</div>
					</div>
				</div>
				<!-- row closed -->
                  
				<!-- edit -->

				<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
			   <div class="modal-dialog" role="document">
				   <div class="modal-content">
					   <div class="modal-header" >
						   <h5 class="modal-title" id="exampleModalLabel" style="text-align: left;">Section Update</h5>
						   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
						   </button>
					   </div>
					   <div class="modal-body">

						   <form action="{{ route('section.update') }}" method="post" autocomplete="off">
							    
						     	@csrf
								@method('PUT')
							   <div class="form-group" style="text-align: left;">
								   <input type="hidden" name="id" id="id" value="">
								   <label for="recipient-name" class="col-form-label">Section Name</label>
								   <input class="form-control" name="section_name" id="section_name" type="text">
							   </div>
							   <div class="form-group" style="text-align: left;">
								   <label for="message-text" class="col-form-label">Notes</label>
								   <textarea class="form-control" id="description" name="description"></textarea>
							   </div>
					   </div>
					   <div class="modal-footer">
						   <button type="submit" class="btn btn-primary">Confirm</button>
						   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					   </div>
					   </form>
				   </div>
			   </div>
		   </div>


		   <div class="modal" id="modaldemo9">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Section Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
																	   type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="{{ route('section.delete') }}" method="post">
						@csrf
						@method('delete')
						
						<div class="modal-body" style="text-align: left;">
							<p>Are you sure of the deletion process?</p><br>
							<input type="hidden" name="id" id="id" value="">
							<input class="form-control" name="section_name" id="section_name" type="text" readonly>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Confirm</button>
						</div>
				</div>
				</form>
			</div>
		</div>


			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
	})
</script>

<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
	})
</script>

@endsection
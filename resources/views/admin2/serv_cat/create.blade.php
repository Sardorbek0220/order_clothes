@extends('admin2.layouts.index')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Create service categories')}}</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal row" action="{{ route('categories.store', app()->getLocale())}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group col-md-12">
                        <label for="name" class="col-sm-4 col-form-label">{{__('Name')}}</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="name" name="name" placeholder="{{__('Name')}}"/>
                        </div>
                      </div> 
                      <div class="form-group col-md-12">
                        <label for="name_ru" class="col-sm-4 col-form-label">{{__('Name')}} (RU)</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="name_ru" name="name_ru" placeholder="{{__('Name')}} (RU)"/>
                        </div>
                      </div> 
                      <div class="form-group col-md-12">
                        <label for="name_en" class="col-sm-4 col-form-label">{{__('Name')}} (EN)</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="name_en" name="name_en" placeholder="{{__('Name')}}"/>
                        </div>
                      </div>  
                      <div class="form-group col-md-12">
                        <label for="img" class="col-sm-4 col-form-label">{{__('Photo')}}</label>
                        <div class="col-sm-12">
                          <input type="file" class="form-control" id="img" name="img" style="padding: 2px;">
                        </div>
                      </div>                 
                      <div class="form-group col-md-2">
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
@endsection
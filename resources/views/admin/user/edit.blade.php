@extends('admin.layouts.index')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Edit user')}}</h1>
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
                    <form class="form-horizontal row" action="{{route('users.update', ['language'=>app()->getLocale(), 'user' => $user->id])}}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="card-body">
                        <div class="form-group">
                          <label for="user_type_id">{{__('User types')}}</label>
                          <select id="user_type_id" class="form-control" name="user_type_id">
                            @foreach($user_types as $data)
                            <option @if($data->id == $user->user_type_id)selected @endif value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="username">{{__('Name')}}</label>
                          <input class="form-control" type="text" name="name" placeholder="{{__('Name')}}" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input class="form-control" name="email" placeholder="Email" type="email" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                          <label for="password">{{__('Password')}}</label>
                         <input class="form-control" type="password" name="password" placeholder="{{__('Password')}}">
                        </div>
                        <div class="form-group">
                          <label for="confirm_password">{{__('Password confirmation')}}</label>
                          <input class="form-control" type="password" name="password_confirmation" placeholder="{{__('Password confirmation')}}" style="margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
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
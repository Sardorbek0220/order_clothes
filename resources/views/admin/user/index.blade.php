@extends('admin.layouts.index')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Users')}}</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex flex-wrap align-items-center">
                  <h3 class="card-title mr-3 mb-0"><a href="{{route('users.create', app()->getLocale())}}" class="btn btn-primary">{{__('Create')}}</a></h3>
                  <form action="{{ route('users', ['language'=>app()->getLocale()]) }}" method="get" class="form-inline">
                    <div class="form-group mr-2">
                      <label for="user_type_id" class="mr-2">{{__('Role')}}</label>
                      <select name="user_type_id" id="user_type_id" class="form-control">
                        <option value="">{{__('All')}}</option>
                        @foreach($user_types as $type)
                          <option value="{{ $type->id }}" {{ $user_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">{{__('Filter')}}</button>
                    <a href="{{ route('users', ['language'=>app()->getLocale()]) }}" class="btn btn-secondary">{{__('Reset')}}</a>
                  </form>
                </div>
              </div>
              <div class="card-body">
                <table id="example" class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 2%">#</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Email')}}</th>
                      <th>{{__('Phone')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Role')}}</th>
                      <th style="width: 10%;" class="text-center">{{__('Action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach( $users as $user )
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email ?: '-' }}</td>
                      <td>{{ $user->phone ?: '-' }}</td>
                      <td>
                        @if(app()->getLocale() == 'en')
                          {{ $user->status->name }}
                        @elseif(app()->getLocale() == 'uz')
                          {{ $user->status->name_uz }}
                        @else
                          {{ $user->status->name_ru }}
                        @endif
                      </td>
                      <td>{{ $user->user_type->name }}</td>
                      <td class="text-nowrap" style="display: flex; justify-content: center;">
                        @if($user->user_type_id == 5)
                        <span class="btn btn-success btn-rounded mr-2 disabled" title="{{__('Customer data cannot be edited')}}">
                          <i class="fa fa-edit text-inverse"></i>
                        </span>
                        @else
                        <a href="{{ route('users.edit', ['user'=>$user->id, 'language'=>app()->getLocale()]) }}" class="btn btn-success btn-rounded mr-2">
                          <i class="fa fa-edit text-inverse"></i>
                        </a>
                        @endif
                        <a href="#" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#view_shop{{ $user->id }}" title="инфо">
                          <i class="fa fa-info text-inverse"></i>
                        </a>
                      </td>

                        <div class="modal fade" id="view_shop{{ $user->id }}" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{__('About user')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{{__('Name')}}: {{ $user->name }} </p>
                                <p>Email: {{ $user->email ?: '-' }}</p>
                                <p>{{__('Phone')}}: {{ $user->phone ?: '-' }}</p>
                                <p>{{__('Address')}}: {{ $user->address ?: '-' }}</p>
                                <p>{{__('Role')}}: {{ $user->user_type->name }}</p>
                              </div>
                              <div class="modal-footer">
                                <form action="{{ route('admin.users.apply', ['user'=> $user->id, 'language'=>app()->getLocale()]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-success" title="{{__('Active')}}">{{__('Active')}}</button>
                                </form>
                                <form action="{{ route('admin.users.delete', ['user' => $user->id, 'language'=>app()->getLocale()]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-danger" title="{{__('Delete')}}">{{__('Delete')}}</button>
                                </form>
                                <form action="{{ route('admin.users.block', ['user' => $user->id, 'language'=>app()->getLocale()]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-warning" title="{{__('Block')}}">{{__('Block')}}</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {!! $users->links() !!}
                  <!-- <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


@endsection
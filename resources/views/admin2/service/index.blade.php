@extends('admin2.layouts.index')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Services')}}</h1>
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
                <h3 class="card-title"><a href="{{ route('services.create', app()->getLocale()) }}" class="btn btn-primary">{{__('Create')}}</a></h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 2%">#</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Price (1kg)')}}</th>
                      <th>{{__('Category')}}</th>
                      <th>{{__('Photo')}}</th>
                      <th>{{__('Status')}}</th>
                      <th style="width: 10%;" class="text-center">{{__('Action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($services as $data)
                  	<tr>
                      <td>{{$data->id}}</td>
                      <td>{{$data->name}}</td>
                      <td>{{$data->price}}</td>
                      <td>{{$data->service_cat->name}}</td>
                      <td>
                        <img height="40" src="{{ asset('storage/'.$data->photo) }}">
                      </td>
                      <td>
                        @if(app()->getLocale() == 'en')
                          {{$data->status->name}}
                        @elseif(app()->getLocale() == 'uz')
                          {{$data->status->name_uz}}
                        @else
                          {{$data->status->name_ru}}
                        @endif
                      </td>
                      <td style="text-align: center;">
                        <a class="d-inline-block mr-2" href="{{ route('services.edit', ['service'=>$data->id, 'language'=>app()->getLocale()]) }}" title="Изменить" class="btn btn-outline-primary">
                          <i class="fa fa-edit"></i>
                        </a>
                        <form class="d-inline-block" action="{{ route('services.destroy', ['service'=>$data->id, 'language'=>app()->getLocale()]) }}" method="post">
                          @csrf
                          @method('DELETE')   
                            <button class="btn btn-outline-danger" title="удалить" type="submit" onclick="return confirm('Подтвердите удаление')"><i class="fa fa-trash"></i></button>   
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
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
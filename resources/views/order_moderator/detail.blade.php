@extends('order_moderator.layouts.index')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Detail of order')}}</h1>
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
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 2%">#</th>
                      <th>{{__('Summa')}}</th>
                      <th>{{__('Weight')}}</th>
                      <th>{{__('Service')}}</th>
                      <th>{{__('Service category')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach( $detail as $order )
                    <tr>
                      <td>{{ $order->id }}</td>
                      <td>{{ $order->summa }}</td>
                      <td>{{ $order->weight }}</td>
                      <td>
                        @if(app()->getLocale() == 'en')
                          {{ $order->service->name_en }}
                        @elseif(app()->getLocale() == 'uz')
                          {{ $order->service->name }}
                        @else
                          {{ $order->service->name_ru }}
                        @endif
                      </td>
                      <td>
                        @if(app()->getLocale() == 'en')
                          {{ $order->service_cat->name_en }}
                        @elseif(app()->getLocale() == 'uz')
                          {{ $order->service_cat->name }}
                        @else
                          {{ $order->service_cat->name_ru }}
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {!! $detail->links() !!}
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
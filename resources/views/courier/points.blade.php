@extends('courier.layouts.index')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Points')}}</h1>
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
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 2%">#</th>
                      <th>{{__('Total summa')}}</th>
                      <th>{{__('Total weight')}}</th>
                      <th>{{__('Address')}}</th>
                      <th>{{__('Phone')}}</th>
                      <th>{{__('Status')}}</th>
                      <th style="width: 10%;" class="text-center">{{__('Action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach( $orders as $order )
                    <tr>
                      <td>{{ $order->id }}</td>
                      <td>{{ $order->total_summa }}</td>
                      <td>{{ $order->total_weight }}</td>
                      <td>{{ $order->address }}</td>
                      <td>{{ $order->phone }}</td>
                      <td>
                        @if(app()->getLocale() == 'en')
                          {{ $order->order_status->name_en }}
                        @elseif(app()->getLocale() == 'uz')
                          {{ $order->order_status->name }}
                        @else
                          {{ $order->order_status->name_ru }}
                        @endif
                        
                      </td>
                      <td class="text-nowrap" style="display: flex; justify-content: center;">
                        <a href="#" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#view_shop{{ $order->id }}" title="инфо">
                          <i class="fa fa-info text-inverse"></i>
                        </a>
                      </td>

                        <div class="modal fade" id="view_shop{{ $order->id }}" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{__('About order')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{{__('Phone')}}: {{ $order->phone }} </p>
                                <p>{{__('Address')}}: {{ $order->address }}</p>
                              </div>
                              <div class="modal-footer">
                                <!-- <form action="{{ route('order_moderator.in_progress', ['order_id'=> $order->id ]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-primary" title="Active">In progress</button>
                                </form> -->
                                <form action="{{ route('courier.canceled', ['order_id'=>$order->id, 'language'=>app()->getLocale()]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-danger" title="Canceled" onclick="return confirm('Подтвердить отмену')">{{__('Cancel')}}</button>
                                </form>
                                <!-- <form action="{{ route('order_moderator.done', ['order_id'=> $order->id ]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-secondary" title="Done">Done</button>
                                </form>
                                <form action="{{ route('order_moderator.sent', ['order_id'=> $order->id ]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-dark" title="Sent">Sent</button>
                                </form> -->
                                <form action="{{ route('courier.delivered', ['order_id'=>$order->id, 'language'=>app()->getLocale()]) }}" method="post">
                                  @csrf
                                  @method('POST')
                                  <button type="submit" class="btn btn-success" title="Delivered" onclick="return confirm('Подтвердить доставку')">{{__('Delivered')}}</button>
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
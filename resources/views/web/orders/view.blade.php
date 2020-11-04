@extends('adminlte::page')

@section('title', 'Orden')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="icon fas fa-file-alt"></i> Orden</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @includeWhen(count($errors->all())>0 , 'web.layouts.errors')
                    @includeWhen(session('update') , 'web.orders.layouts.updateMessages')
                    <div class="card">
                        <div class="card-header bg-gradient-orange">
                            <h3 class="card-title"><i class="icon fas fa-receipt"></i> Detalle de la Orden</h3>
                        </div>                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-tags"></i> <label>Cantidad:</label>
                                        <span class="text-orange">{{ $order->quantity }}</span>
                                    </div>                                
                                </div>    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-dollar-sign"></i> <label>Total:</label>
                                        <span class="text-orange">{{ $order->total_format }}</span>
                                    </div>                                
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-eye"></i> <label>Estado:</label>
                                        <span class="text-orange">{{ $order->status }}</span>
                                    </div>                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-calendar-plus"></i> <label>Creada:</label>
                                        <span class="text-orange">{{ $order->created_at }}</span>
                                    </div>                                
                                </div>    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-calendar-check"></i> <label>Actualizada:</label>
                                        <span class="text-orange">{{ $order->updated_at }}</span>
                                    </div>                                
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <i class="fa fa-fw fa-calendar-minus"></i> <label>Eliminada:</label>
                                        <span class="text-orange">{{ $order->deleted_at }}</span>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn bg-secondary mb-5" href="{{ route('orders.index') }}">
                                <i class="fas fa-chevron-circle-left"></i> Volver
                            </a>
                            @includeWhen(Auth::user()->can('pay', $order) , 'web.orders.layouts.buttonPay')                            
                        </div>                        
                    </div>
                    @include('web.orders.layouts.transactionList')                    
                </div>
            </div>
        </div>
    </div>
@stop

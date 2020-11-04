<div class="card">
    <div class="card-header bg-gradient-olive">
        <h3 class="card-title"><i class="icon fas fa-file-invoice-dollar"></i> Transacciones</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>                            
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12" style="overflow: auto;">
                <table id="tbl_transactions" class="table table-striped table-bordered text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Referencia</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th>Eliminado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->transactions->count()==0)
                            <tr>
                                <td colspan="5" class="text-center text-danger">
                                    No hay transacciones en esta orden.
                                </td>
                            </tr>
                        @endif
                        @foreach ($order->transactions as $transaction)
                            <tr class="bg-success disabled color-palette">
                                <td>
                                    {{$transaction->current_status}}
                                </td>
                                <td>
                                    {{$transaction->reference}}
                                </td>
                                <td>
                                    {{$transaction->created_at}}
                                </td>
                                <td>
                                    {{$transaction->updated_at}}
                                </td>
                                <td>
                                    {{$transaction->deleted_at}}
                                </td>                                                    
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr class="bg-teal color-palette">
                                                <th colspan="3" class="text-center">
                                                    Estados de la transaccion {{$transaction->reference}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaction->transaction_states as $states)
                                                <tr>
                                                    <td class="text-center">
                                                        {{$states->status}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$states->updated_at}}
                                                    </td>                                                    
                                                    <td class="text-center">
                                                        {{$states->message??'N/A'}}
                                                    </td>                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>                                    
            </div>
        </div>
    </div>
</div>
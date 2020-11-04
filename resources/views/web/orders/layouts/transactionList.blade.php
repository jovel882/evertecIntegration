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
            <div class="col-sm-12">
                <table id="tbl_transactions" class="table table-striped table-bordered" style="width:100%">
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
                        @foreach ($order->transactions as $transaction)
                            <tr>
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
                        @endforeach
                    </tbody>
                </table>                                    
            </div>
        </div>
    </div>
</div>
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_transactions').DataTable({
                "processing": true,
                "language": {!! __('general.data-table') !!},                
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    },                    
                ],
                "order": [2, "desc"],
                "scrollX": true,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": true,                
            });
        });        
    </script>    
@endpush
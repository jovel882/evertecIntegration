<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-fw fa-times-circle"></i></button>
    @foreach ($errors->all() as $error)
        <div style="margin-bottom: 1em;">
            <i class="fa fa-fw fa-exclamation-triangle"></i> {{ $error }}
        </div>
    @endforeach
</div>
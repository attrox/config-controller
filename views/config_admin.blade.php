
@if (!empty($alert_msg))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ $alert_msg }}
    </div>
@endif

{!!  Form::open(array('method' => 'post')) !!}
{!! Form::token() !!}
@foreach ($input as $key => $val)
    <div class="row">
        <div class="col-md-4">
            {!! Form::label($key, $key) !!}:
        </div>
        <div class="col-md-6">
            {!! Form::$val($key, $content[$key]) !!}
        </div>
    </div>
@endforeach
<div class="row">
    <input type="submit" class="btn btn-primary" value="Save">
</div>
{!! Form::close() !!}

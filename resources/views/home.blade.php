@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Location Form</div>

                    <div class="panel-body">

                        <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                                @endif
                            @endforeach
                        </div>

                        {{ Form::open(array('url' => '/callApi')) }}
                        {{ 'Address:' }}
                        <input class="form-control" type="text" name="address" id="address" value="{{ isset($description) ? $description : '' }}">
                        @if ($errors->has('address'))
                            <div class="text-danger">{{ $errors->first('address') }}</div>
                        @endif
                        <br>
                        {{ Form::submit('Submit') }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
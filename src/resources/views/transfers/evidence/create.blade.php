{!! Form::open(['route' => ['transfers.evidence.store', $transfer_id], 'method' => 'post', 'files' => true]) !!}
    {!! Form::label('evidence[]', 'Evidence') !!}
    {!! Form::file('evidence[]', ['multiple' => true]) !!}
    @error('evidence')
        <span class="alert alert-danger">{{ $message }}</span>
    @enderror
    {!! Form::submit('Upload') !!}
{!! Form::close() !!}

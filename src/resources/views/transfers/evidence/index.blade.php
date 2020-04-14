@foreach($transfer_evidences as $transfer_evidence)
    <p>{{ $transfer_evidence }}</p>
    {!! Form::open(['route' => ['transfers.evidence.destroy', $transfer_id, $transfer_evidence->id], 'method' => 'delete']) !!}
        {!! Form::submit('Delete') !!}
    {!! Form::close() !!}
@endforeach

@extends('layouts.app')

@section('content')
<div class="container">
    <journals-form :client='@json($client)'></journals-form>
</div>
@endsection

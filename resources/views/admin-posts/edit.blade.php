@extends('layouts.app')
@section('content')
    <editpost-component :post='{!! json_encode($post, JSON_HEX_APOS|JSON_HEX_QUOT) !!}' category_idcsv="{{$post->category_idcsv}}"></editpost-component>
@endsection
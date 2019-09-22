@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Post List</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div><advanced-table resourceurl="/posts_list?sort=id-desc" editurl="/posts/edit" viewurl="/posts"></advanced-table></div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')

  <div class="d-flex justify-content-between">
    <div class="p-2">
        <h2>@lang('posts.last_posts')</h2>
    </div>

  </div>

  @include ('posts/_list')
@endsection

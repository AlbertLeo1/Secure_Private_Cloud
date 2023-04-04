@extends('layouts.main')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row " style="padding-left:15px !important">
        @foreach ($sections as $section)
        <div class="col-sm-4">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                  <h5 class="card-title"><strong>{{ $section->s_desc}}</strong></h5>
                  <h6 class="card-subtitle mb-2 text-muted">{{ $section->g_desc}}</h6>
                  <p class="card-text">Section in Calamba Adventist Elementary School.</p>
                  <a href="/teacher/handled/section?s_code={{$section->s_code}}" class="btn btn-primary">Manage Section</a>
                </div>
              </div>
        </div>
        @endforeach
        

        {{-- <div class="col-4">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
        </div> --}}
      </div>
</div>
@endsection

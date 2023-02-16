@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row " style="padding-left:15px !important;">
        @foreach ($subjects as $subject)
        <div class="col-sm-4 pt-4">
            <div class="card" style="width: 20rem; border-color:{{$subject->color}}">
                <div class="card-body">
                  <h3 class="card-title"><i class="{{$subject->icon}}" style="color:{{$subject->color}}"></i> <strong>{{ $subject->subj_code}}</strong></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><strong>Subject:</strong> {{ $subject->subj_desc}}</h6>
                  {{-- <p class="card-text mb-0">Teacher: {{ $subject->first_name." ".$subject->last_name}}</p> --}}
                  <p class="card-text">Calamba Adventist Elementary School.</p>
                  <a href="/teacher/scoresheet?subj_code={{$subject->subj_code}}&&section_code={{$subject->section_code}}" class="btn btn-primary">View Score Sheet</a>
                </div>
              </div>
        </div>
        @endforeach
        
      </div>
</div>
@endsection

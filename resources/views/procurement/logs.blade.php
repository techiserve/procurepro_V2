@extends('coreui.layouts.admin')


<style>
    body{
    margin-top:20px;
    background:#eee;
}

.timeline {
    display: grid;
    grid-template-columns: .25rem 1fr;
    grid-auto-columns: -webkit-max-content;
    grid-auto-columns: max-content;
    -webkit-column-gap: 2rem;
    -moz-column-gap: 2rem;
    column-gap: 2rem;
    list-style: none
}

.timeline::before {
    content: "";
    grid-column: 1;
    grid-row: 1/span 20;
    background: #f8f7fa
}

.timeline li {
    grid-column: 2;
    margin-inline:1.5rem;
    grid-row: span 2;
    display: grid;
    grid-template-rows: -webkit-min-content -webkit-min-content -webkit-min-content;
    grid-template-rows: min-content min-content min-content
}

.timeline li:not(:last-child) {
    margin-bottom: 2rem
}

.timeline li .date {
    height: 3rem;
    margin-inline:-1.5rem;
    text-align: center;
    color: #fff;
    display: grid;
    place-content: center;
    position: relative;
    border-radius: 1.5rem 0 0 1.5rem
}

.timeline li .date::before {
    content: "";
    width: 1.8rem;
    aspect-ratio: 1;
    background: #f8f7fa;
    position: absolute;
    top: 100%;
    -webkit-clip-path: polygon(0 0,100% 0,0 100%);
    clip-path: polygon(0 0,100% 0,0 100%);
    right: 0
}

.timeline li .date::after {
    content: "";
    display: block;
    position: absolute;
    width: 14px;
    height: 14px;
    background: #663b6c;
    border-radius: 15px;
    z-index: 1;
    top: 50%;
    -webkit-transform: translate(50%,-50%);
    transform: translate(50%,-50%);
    right: calc(100% + 2rem + .125rem)
}

.timeline li .title {
    position: relative;
    padding-inline:1.5rem;overflow: hidden;
    -webkit-padding-before: 1.5rem;
    padding-block-start:1.5rem;-webkit-padding-after: 1rem;
    padding-block-end:1rem;font-weight: 500
}

.timeline li .title::before {
    bottom: calc(100% + .125rem)
}

.timeline li .descr {
    position: relative;
    padding-inline:1.5rem;-webkit-padding-after: 1.5rem;
    padding-block-end:1.5rem;font-weight: 300
}

.timeline li .descr::before {
    z-index: -1;
    bottom: .25rem
}

@media (min-width: 40rem) {
    .timeline {
        grid-template-columns:1fr .25rem 1fr
    }

    .timeline::before {
        grid-column: 2
    }

    .timeline li:nth-child(odd) {
        grid-column: 1
    }

    .timeline li:nth-child(odd) .date {
        border-radius: 0 1.5rem 1.5rem 0
    }

    .timeline li:nth-child(odd) .date::before {
        -webkit-clip-path: polygon(0 0,100% 0,100% 100%);
        clip-path: polygon(0 0,100% 0,100% 100%);
        left: 0
    }

    .timeline li:nth-child(odd) .date::after {
        -webkit-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
        left: calc(100% + 2rem + .125rem)
    }

    .timeline li:nth-child(even) {
        grid-column: 3
    }

    .timeline li:nth-child(2) {
        grid-row: 2/4
    }
}

.timeline .timeline-date {
    width: 54px;
    height: 85px;
    display: inline-block;
    padding: 8px;
    -webkit-clip-path: polygon(0 0,100% 0,100% 80%,50% 100%,0 80%);
    clip-path: polygon(0 0,100% 0,100% 80%,50% 100%,0 80%);
    z-index: 1
}

h5, h6 {
    color:#201f26 !important;
}
</style>

@section('content')

<div class="container">

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                
                <div class="card-body">
                <div class="row mt-3">
                    <div class="col-xl-12">
                        <!-- <a href="{{ url()->previous() }}" class="btn btn-primary btn-rounded waves-effect waves-light">
                            ← Return Back
                        </a> -->
                    </div>
                </div>
                    <div class="row justify-content-center mt-4 pt-3">
                        <div class="col-xl-10">
                            <ul class="timeline mb-0">
                            @foreach($histories as $history)
                                <li>
                                @php
                                    $date = \Carbon\Carbon::parse($history->created_at);
                                    @endphp
                                    <div class="date bg-light">
                                        <h5 class="text-uppercase mb-0 fs-16">Year {{$date->format(' Y')}}</h5>
                                    </div>
                                   
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="event-content">
                                                <div class="timeline-date bg-primary text-center rounded float-end">
                                                    <h3 class="text-white mb-0 fs-17">{{$date->format('d')}}</h3>
                                                    <p class="mb-0 text-white-50">{{$date->format('M')}}</p>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3 class="fs-17">{{$history->action}}</h3>
                                                    <p class="mb-0 mt-2 pt-1 text-muted" > <h4 > Done by: {{$history->doneby}}</Done></h4></p>

                                                    <button class="btn btn-success btn-rounded waves-effect waves-light mt-4">
                                                    {{$date->format('h:i:s')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach                           
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
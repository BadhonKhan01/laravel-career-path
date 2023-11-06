@extends('layout.app')

@section('hero')
    <div class="heroArea hero-content" style="background: url('{{ asset('storage/img/webExp.jpg') }}')">
        <h1>Work experience</h1>
    </div>
@endsection

@section('conent')

    <!-- ======= Experience Section ======= -->
    <div id="experience">
        <div class="container">
            <ul>
                @if (sizeof($experience) > 0)
                    @php
                        $colors = ['#41516C','#FBCA3E','#E24A68','#1B5F8C'];
                    @endphp
                    @foreach (array_reverse($experience) as $key => $item)
                        <li style="--accent-color:{{ $colors[$key] }}">
                            <div class="date">{{ $item['start'] }} - {{ (empty($item['end'])) ? 'Present' : $item['end'] }}</div>
                            <div class="title">{{ $item['name'] }}</div>
                            <div class="title">{{ $item['role'] }}</div>
                            <div class="descr">{{ $item['description'] }}</div>
                        </li>
                    @endforeach
                @endif
            </ul>

        </div>

    </div><!-- End Services Section -->
@endsection

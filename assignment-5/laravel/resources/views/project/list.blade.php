@extends('layout.app')

@section('hero')
    <div class="heroArea hero-content" style="background: url('{{ asset('storage/img/webExp.jpg') }}')">
        <h1>My Projects</h1>
    </div>
@endsection

@section('conent')
    <!-- ======= Blog Grid ======= -->
    <div id="journal-blog" class="text-left  paddsections">

        <div class="container">
            <div class="journal-block">
                <div class="row">
                    @if (sizeof($projects) > 0)
                        @foreach ($projects as $item)
                            <div class="col-lg-4 col-md-6">
                                <div class="journal-info mb-30">

                                    <a href="{{ route('projects.detail',['slug' => $item['slug']]) }}">
                                        <img src="{{ asset('storage/img/'.$item['image']) }}" class="img-responsive" alt="{{ $item['name'] }}">
                                    </a>

                                    <div class="journal-txt">

                                        <h4><a href="{{ route('projects.detail',['slug' => $item['slug']]) }}">{{ $item['name'] }}</a></h4>
                                        <p class="separator">{{ $item['support'] }}</p>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div><!-- End Blog Grid -->
@endsection

@extends('layout.app')

@section('hero')
    <div class="heroArea hero-content" style="background: url('{{ asset('storage/img/webExp.jpg') }}')">
        <h1>My Projects</h1>
    </div>
@endsection

@section('conent')
    <!-- ======= Blog Single ======= -->
    <div class="main-content paddsection">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="container-main single-main">
                            <div class="col-md-12">
                                <div class="block-main mb-30">
                                    <img src="{{ asset('storage/img/'.$detail['image']) }}" class="img-fluid" alt="{{ $detail['name'] }}">
                                    <div class="content-main single-post padDiv">
                                        <div class="journal-txt">
                                            <h4><a href="#">{{ $detail['name'] }}</a></h4>
                                        </div>
                                        <div class="post-meta">
                                            <ul class="list-unstyled mb-0">
                                                <li class="author">Support:<a href="#">{{ $detail['support'] }}</a></li>
                                            </ul>
                                        </div>
                                        <p class="mb-30">{{ $detail['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Blog Single -->
@endsection

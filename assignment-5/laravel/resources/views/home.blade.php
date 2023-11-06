@extends('layout.app')

@section('hero')
    <div id="hero" class="home" @if ($hero['image']) style="background-image: url('{{ asset("storage/img/".$hero['image']) }}') @endif">

        <div class="container">
            <div class="hero-content">
                <h1>I'm <span class="typed"
                        data-typed-items="{{ $hero['typeItem'] }}"></span></h1>
                <p>{{ $hero['shortInfo'] }}</p>

                <ul class="list-unstyled list-social">
                    @if (sizeof($hero['socials']) > 0)
                        @foreach ($hero['socials'] as $key => $item)
                            <li><a href="{{ $item['url'] }}"><i class="bi bi-{{ $item['icon'] }}" title="{{ $key }}"></i></a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div><!-- End Hero -->
@endsection

@section('conent')
    <!-- ======= About Section ======= -->
    <div id="about" class="paddsection">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-4 ">
                    <div class="div-img-bg">
                        <div class="about-img">
                            <img src="{{ asset("storage/img/".$bio['image']) }}" class="img-responsive" alt="me">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-descr">
                        <p class="p-heading">{{ $bio['title'] ?? '' }}</p>
                        <p class="separator">{{ $bio['description'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <div id="services">
        <div class="container">

            <div class="services-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    @if (sizeof($bio['services']) > 0)
                        @foreach ($bio['services'] as $item)
                            <div class="swiper-slide">
                                <div class="services-block">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['name'] }}</span>
                                    <p class="separator">{{ $item['description'] }}
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->
                        @endforeach
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </div><!-- End Services Section -->
@endsection

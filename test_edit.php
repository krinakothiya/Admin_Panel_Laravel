@extends("frontend.layouts.master")
@section("frontend_content")
<!-- Inner Page Banner --->
<div class="innerpageBanner" id="home">
    <div class="innerpagegraybox"></div>
    <div class="innerpageptrnbox" style="background-image: url('{{ asset('public/front-assets/images/about-ttlbanner.png') }}');">
        <div class="container">
            <div class="innerpagebannerimg">
                <div class="innertitlebox">
                    <h1 class="font-three fw-bold color-black hmmaintitle35">{{$receipe->article_title}}</h1>
                    <!--- <nav aria-label="breadcrumb" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><img src="./images/home.png" alt="Home Icon"></a></li>
                    <li class="breadcrumb-item active" aria-current="page">The Ramailo Story</li>
                  </ol>
                  </nav>-->
                    <ul class="breadcrumblist">
                        <li class=""><a href="{{url('/')}}"><img src="{{ asset('public/front-assets/images/home.png')}}" alt="Home Icon"></a></li>
                        <li class=""><i class="bi bi-chevron-double-right"></i></li>
                        <li class=""><a href="{{url('receipe')}}">Recipe</a></li>
                        <li class=""><i class="bi bi-chevron-double-right"></i></li>
                        <li class="active" aria-current="page">{{$receipe->article_title}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-------- Receipe Detail Image --------->
<section class="recp_detail pdtop pdbtm">
    <div class="container">
        <!--<div class="titlebox text-center">
      <h2 class="hmmaintitle font-three fw-semibold color-blue">Bakery Receipe Detail Page</h2>
    </div>-->
        <div class="recp_detailimgbox mrtop20 text-center">
            @if($receipe->article_thumbnail != null)
            <img src="{{asset('public/assets/images/article_thumbnail/' 
    @else
    <img src="{{asset('public/front-assets/images/rcp_detail.png')}}" alt="Receipe detail">
            @endif
        </div>

        <div class="recp_detaildscbox mrtop60">
            <div class="recp_detaildatebox mrtop60">
                <ul class="rcpdtlist">
                    <li>
                        <p class="font-three fw-medium ><img src=" {{ asset('public/front-assets/images/calendar.png') }}" alt="Calendar"> {{ \Carbon\Carbon::parse($receipe->created_at)->format('d. m. Y') }}</p>
                    </li>
                    <li> | </li>
                    <li>
                        <p class="font-three fw-medium color-black hmmaindesc16">
                    <li>
                        <p class="font-three fw-medium color-black hmmaindesc16"><!-- ShareThis BEGIN -->
                        <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END --></p>
                    </li>
                </ul>
            </div>
            <p class="font-three fw-medium color-black mrtop40">{!! htmlspecialchars_decode($receipe->article_description) !!}</p>
            <!-- <p class="font-three fw-medium color-black">The cake is then glazed with a shiny chocolate glaze, which adds a beautiful finish and also helps to seal the layers together. The final touch is often a decoration on top with fresh cherries, chocolate curls and sprinkle of cocoa powder.</p> -->
        </div>
    </div>
</section>

<section class="recp_detailbox pdtop pdbtm">
    <div class="container">
        <div class="recp_detailboxinner">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-12 rcpdtl-col">
                    <div class="rcpdtinner">
                        <img src="{{asset('public/front-assets/images/bake-temp.png')}}" alt="Bake Temp">
                        <h3 class="font-three color-black hmmainsbtitle22 rcpdsc mrtop20"><span class="fw-bold">BAKE TEMP</span> - {{$receipe->bake_temp}}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-12 rcpdtl-col">
                    <div class="rcpdtinner">
                        <img src="{{asset('public/front-assets/images/mixing-time.png')}}" alt="MIXING TIME">
                        <h3 class="font-three color-black hmmainsbtitle22 rcpdsc mrtop20"><span class="fw-bold">MIXING TIME </span>- {{$receipe->mixing_time}}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-12 rcpdtl-col">
                    <div class="rcpdtinner">
                        <img src="{{asset('public//prep-time.png')}}" alt="PREP TIME">
                        <h3 class="font-three color-black hmmainsbtitle22 rcpdsc mrtop20"><span class="fw-bold"> PREP TIME </span>- {{$receipe->prep_time}}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-12 rcpdtl-col">
                    <div class="rcpdtinner">
                        <img src="{{asset('public/front-assets/images/bake-time.png')}}" alt="BAKE TIME">
                        <h3 class="font-three color-black hmmainsbtitle22 rcpdsc mrtop20"><span class="fw-bold">BAKE TIME </span> - {{$receipe->bake_time}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-------- Related Products End--------->
<!-------- Receipe Detail --------->
@if(isset($receipe) && $receipe->steps)
<section class="rcpdetailbox pdtop pdbtm">
    <div class="container">
        <div class="rcpdtlboxinr2">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 rcpdtl-col rcpdtl-coldevider">
                    <div class="rcpdtlcolinr">
                        <h4 class="font-three fw-bold color-blue4" @endforeach -->
                            </ul>
                    </div>
                </div>
                @if(isset($receipe) && $receipe->steps)fw-bold color-blue4">Method</h4>
                <ul class="ingrdesc mrtop40">
                    {!! htmlspecialchars_decode($receipe->steps) !!}
                </ul>
            </div>
        </div>
        @endif

    </div>
    </div>
    </div>
</section>
@endif

<!-------- Use Product --------->
<!-------- Use Product --------->
@if($article_product)
<div class="devider2"></div>
<section class="useproduct pdtop pdbtm">
    <div class="container">
        <div class="title useproductttl text-center">
            <h2 class="font-three fw-bold color-black">Use this product for this Recipe <img src="{{asset('public/front-assets/images/arrow-down2.png')}}"></h2>
        </div>
        <div class="useproductbox">
            <div class="useproductinner">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 up-col">
                        <div class="up-colinner">
                            @if($article_product->product_thumbnail != null)
                            <img src="{{asset('public/assets/images/product_thumbnail/' . $article_product->product_thumbnail)}}" alt="Receipe detail" style="width: 178px; height: 254px;">
                            @else
                            <img src="{{asset('public/front-assets/images/choco-sponge-cake.png')}}" alt="product detail">
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 up-col">
                        <div class="up-colinner">
                            <h4 class="font-three fw-semibold color-blue4 ">{{$article_product->product_title}}</h4>
                            <p class="font-three fw-normal color-black hmmaindesc mrtop30">
                                <?php
                                $overview = html_entity_decode($article_product->product_overview);
                                $limitedOverview = strlen($overview) > 135 ? substr($overview, 0, 135) . '...' : $overview;
                                ?>
                                {!! $limitedOverview !!}
                            </p>

                            <a href="{{url('product-details')}}\{{$article_prproduct</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif
<!-------- Use Product End --------->

<!-------- Use Product End --------->
<!-------- Receipe Detail End --------->
@endsection      
@section('script')
<script async="" src="https://buttons-config.sharethis.com/js/65fa87920afe31001276ba8f.js"></script>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=65fa87920afe31001276ba8f&amp;product=sop" async="async"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
     document.querySelector('header').classList.add('innerheader');
   });
</script>
@endsection  
@section('frontend_footer_links')
@endsection
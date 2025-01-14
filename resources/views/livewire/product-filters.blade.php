<section class="product-area">



    <div class="grid-list-box">

        <div class="row">
            <div class="col-xl-12">
                <h2> {{ __('all_products') }} </h2>
            </div>
            <!--<div class="col-xl-12  baseline">
                <h6> <a class="desable" href="#"> {{__('products')}} </a> <i class="fa fa-angle-right"></i> <span><a href="{{route('home',app()->getLocale())}}"> {{__('home')}}
                        </a>
                    </span> </h6>

            </div>-->
        </div>


        <!--<div class="row sort-area">-->

        <!--  <div class="col-xl-5 col-lg-5 col-md-9 col-12 sort">-->

        <!--    <h6> <i class="fas fa-sort"></i> Sort by : </h6>-->
        <!--    <div id="wrapper">-->
        <!--      <select>-->
        <!--        <option selected> Name </option>-->
        <!--        <option value="3"> Featured </option>-->
        <!--        <option value="1"> Latest </option>-->
        <!--      </select>-->
        <!--    </div>-->
        <!--  </div>-->


        <!--  <div class="col-xl-2 col-lg-2 col-md-3 col-3 dc-view-switcher">-->

        <!--    <button class="active" data-trigger="grid-view">-->

        <!--    </button>-->
        <!--    <button data-trigger="list-view">-->

        <!--    </button>-->
        <!--  </div>-->
        <!--</div>-->

    </div>


    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-8 left-filter mx-auto">



            <div class="accordian">
                <h4> {{__('filter')}}</h4>
                <span class="clear-all"> <a href="javascript:void(0);" wire:click="resetFilters">{{__('clear')}} </a>
                </span>
                <!-- search -->
                <div class="col-xl-12 col-lg-12 col-md-12 pro-all-search">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="{{__('search')}}" aria-label="Search" wire:model="keyword">
                        <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit" data="trigger"> <i
                                        class="fas fa-search"></i> </button> -->
                    </form>
                </div>

                <!-- search -->
                <ul>

                    <li><input type="checkbox" checked=""><i></i>
                        <h5> {{__('category')}} </h5>
                        <div class="artlist">
                            <div class="artlist_content">
                                <!-- check box -->
                                @foreach ($categories as $cat)
                                <label class="container-l">{{ $cat->trans_title }}
                                    <input type="checkbox" value="{{ $cat->id }}" wire:model="category">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach

                                @foreach ($sub_categories as $sub)
                                <label class="container-l">{{ $sub->trans_title }}
                                    <input type="checkbox" value="{{ $sub->id }}" wire:model="category">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach

                                <!-- check box -->
                            </div>
                        </div>
                    </li>


                    <li><input type="checkbox" checked=""><i></i>
                        <h5> {{__('brands')}} </h5>
                        <div class="artlist">
                            <div class="artlist_content">
                                <!-- check box -->
                                @foreach ($brands as $bran)
                                <label class="container-l">{{ $bran->title }}
                                    <input type="checkbox" value="{{ $bran->id }}" wire:model="brand">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach



                                <!-- check box -->
                            </div>
                        </div>
                    </li>





                </ul>
            </div>

            <!--// first -->

        </div>
        <div class="col-xl-9 col-lg-8 col-md-12 grid-list-box">





            <div class="download-cards" data-view="grid-view">
			
                @foreach ($products as $product)
                <article class="download-card product-list">

                    <a href="{{ route('show-product', ['locale' => app()->getLocale(), 
          'cslug' => $product->trans_main_category_slug,'scslug' => $product->trans_category_slug,'slug' => $product->trans_product_slug]) }}">
                        <img class="bode-img" src="{{ env('APP_ADMIN_URL') }}{{ $product->brand_image }}" alt="{{ $product->brand_name }}">
                        <div class="download-card-img-box">
                            <div class="download-card__image">
                                <img src="{{ env('APP_ADMIN_URL') }}{{ $product->image }}" alt="{{ $product->trans_product }}">
                            </div>
                        </div>

                        <div class="download-card__content">
                            <h5 class="download-card__title"> {{ $product->trans_product }} </h5>
                            <h6 class="brand"> {{ $product->trans_category }} </h6>
                    </a>
                    <a class="mob-nmbr" href="#"> <i class="fas fa-phone"></i> +971 6 5264382 </a>
                    <footer><a class="button" href="{{ route('show-product', ['locale' => app()->getLocale(), 
          'cslug' => $product->trans_main_category_slug,'scslug' => $product->trans_category_slug,'slug' => $product->trans_product_slug]) }}">
                            <span>{{__('view_product')}} </span></a></footer>
            </div>
            </a>
            </article>
            @endforeach










        </div>
        <div class="row" style="padding-top: 13px;padding-left: 17px;">
            {{ $products->links() }}
        </div>
        <!--// grid & list view -->
    </div>

    </div>

</section>
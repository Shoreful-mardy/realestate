@php
 $ptype = App\Models\PropertyType::latest()->limit('5')->get();

@endphp
<section class="category-section centred">
            <div class="auto-container">
                <div class="inner-container wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <ul class="category-list clearfix">

                        @foreach($ptype as $type)

                        @php 
                          $property = App\Models\Property::where('ptype_id', $type->id)->get();
                        @endphp
                        <li>
                            <div class="category-block-one">
                                <div class="inner-box">
                                    <div class="icon-box"><i class="{{$type->type_icon}}"></i></div>
                                    <h5><a href="{{ route('property.type',$type->id)}}">{{ $type->type_name}}</a></h5>
                                    <span>{{ count($property)}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                    <div class="more-btn"><a href="categories.html" class="theme-btn btn-one">All Categories</a></div>
                </div>
            </div>
        </section>

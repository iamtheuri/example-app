@props(['product'])

<x-card>
                    <div class="flex">
                        <img
                            class="hidden w-48 mr-6 md:block"
                            src="{{$product->logo ? asset('storage/' . $product->logo) : asset('/images/no-image.png')}}" 
                            alt=""
                        />
                        <div>
                            <h3 class="text-2xl">
                                <a href="/products/{{$product->id}}">{{$product->title}}</a>
                            </h3>
                            <div class="text-xl font-bold mb-4">{{$product->company}}</div>
                            <x-product-tags :tagsCsv="$product->tags" />
                            <div class="text-lg mt-4">
                                <i class="fa-solid fa-location-dot"></i> {{$product->location}}
                            </div>
                        </div>
                    </div>
</x-card>
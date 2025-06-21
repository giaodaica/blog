<div class="row g-0 mb-4 md-mb-35px" id="review-list-container">
    @if($reviews->count() > 0)
        @foreach ($reviews as $review)
        <div class="col-12 border-bottom border-color-extra-medium-gray pb-40px mb-40px xs-pb-30px xs-mb-30px">
            <div class="d-block d-md-flex w-100 align-items-center">
                <div class="w-300px md-w-250px sm-w-100 sm-mb-10px text-center">
                    <img src="{{ asset('assets/images/avt.jpg') }}" class="rounded-circle w-70px mb-10px" alt="">
                    <span class="text-dark-gray fw-600 d-block">{{ $review->user->name }}</span>
                    <div class="fs-14 lh-18">{{ $review->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="w-100 last-paragraph-no-margin sm-ps-0 position-relative text-center text-md-start">
                    <span class="text-golden-yellow ls-minus-1px mb-5px sm-me-10px sm-mb-0 d-inline-block d-md-block">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </span>
                    <p class="w-85 sm-w-100 sm-mt-15px">{{ $review->content }}</p>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="col-12 text-center">
            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
        </div>
    @endif
</div>


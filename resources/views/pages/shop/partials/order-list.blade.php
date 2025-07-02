@if ($orders->count() > 0)
    @foreach ($orders as $order)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <!-- Order Header -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <div class="mb-2 mb-md-0">
                        <span class="text-muted small">Mã đơn
                            hàng: #{{ $order->code_order }}</span>
                        <span class="text-muted small ms-2">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                    @php
                        $statusConfig = match ($order->status) {
                            'pending' => ['color' => 'warning', 'text' => 'Chờ xác nhận'],
                            'confirmed' => ['color' => 'info', 'text' => 'Đã xác nhận'],
                            'shipping' => ['color' => 'primary', 'text' => 'Đang vận chuyển'],
                            'completed' => ['color' => 'success', 'text' => 'Đã giao hàng'],
                            'cancelled' => ['color' => 'danger', 'text' => 'Đã hủy'],
                            default => ['color' => 'secondary', 'text' => ucfirst($order->status)],
                        };
                    @endphp
                    <span class="badge bg-{{ $statusConfig['color'] }}-subtle text-{{ $statusConfig['color'] }}">
                        {{ $statusConfig['text'] }}
                    </span>
                </div>

                <!-- Order Items -->
                @foreach ($order->orderItems as $item)
                    <div class="row g-3 mb-3">
                        <!-- Product Image -->
                        <div class="col-4 col-md-2">
                            @if ($item->productVariant && $item->productVariant->product)
                                <img src="{{ asset($item->productVariant->product->image_url) }}"
                                    alt="{{ $item->product_name }}" class="img-fluid rounded w-100" />
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height: 80px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="col-8 col-md-7">
                            <h6 class="mb-1">{{ $item->product_name }}
                            </h6>
                            @if ($item->productVariant)
                                <p class="text-muted small mb-1">
                                    @if ($item->productVariant->size)
                                        Size:
                                        {{ $item->productVariant->size->size_name }}
                                    @endif
                                    @if ($item->productVariant->color)
                                        | Màu:
                                        {{ $item->productVariant->color->color_name }}
                                    @endif
                                </p>
                            @endif
                            <p class="text-muted small mb-0">Số lượng:
                                {{ $item->quantity }}</p>
                        </div>

                        <!-- Price -->
                        <div class="col-12 col-md-3 text-start text-md-end">
                            <h6 class="text-danger mb-2">
                                {{ number_format($item->sale_price * $item->quantity, 0, ',', '.') }}₫
                            </h6>
                        </div>
                        <!-- Action Buttons -->
               
                        <div class="text-end" style="margin-top: -30px;">
                            <a href="" class="text-black">
                                <i class="bi bi-eye me-1"></i>
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                @endforeach

                <!-- Order Summary -->
                <div class="border-top pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">
                                <strong>Phương thức thanh toán:</strong>
                                @if ($order->pay_method == 'COD')
                                    Tiền mặt khi nhận hàng
                                @elseif($order->pay_method == 'VNPAY')
                                    VNPAY
                                @else
                                    {{ $order->pay_method }}
                                @endif
                            </p>
                            @if ($order->shipping_fee > 0)
                                <p class="text-muted small mb-1">
                                    <strong>Phí vận chuyển:</strong>
                                    {{ number_format($order->shipping_fee, 0, ',', '.') }}₫
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-primary mb-0">
                                <strong>Tổng cộng:
                                    {{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                            </h6>
                        </div>
                    </div>
                    
                    
                    </div>
                </div>


            </div>
        </div>
    @endforeach
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 text-center">
            <i class="bi bi-bag-x fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">{{ $emptyMessage ?? 'Chưa có đơn hàng nào' }}</h5>
            @if (!isset($emptyMessage))
                <p class="text-muted">Bạn chưa có đơn hàng nào. Hãy mua sắm ngay!</p>
                <a href="{{ route('home.shop') }}" class="btn btn-primary">Mua sắm ngay</a>
            @endif
        </div>
    </div>
@endif

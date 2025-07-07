<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Thêm người quản trị</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <form class="user-form" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="user-name" class="form-label">Họ tên</label>
                            <input type="text" id="user-name" name="name" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <label for="user-email" class="form-label">Email</label>
                            <input type="email" id="user-email" name="email" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="user-password" class="form-label">Mật khẩu</label>
                            <input type="password" id="user-password" name="password" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="user-password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" id="user-password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="user-phone" class="form-label">Số điện thoại</label>
                            <input type="text" id="user-phone" name="default_phone" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="user-address" class="form-label">Địa chỉ</label>
                            <input type="text" id="user-address" name="default_address" class="form-control">
                        </div>

                        {{-- Vai trò mặc định là guest (ẩn) --}}
                        <input type="hidden" name="role" value="admin">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

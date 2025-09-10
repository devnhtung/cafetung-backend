<x-filament-panels::page>
    <div class="max-w-xl mx-auto mt-8 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Thông tin cá nhân</h2>
        <div class="mb-2"><strong>Họ tên:</strong> {{ $user->name }}</div>
        <div class="mb-2"><strong>Email:</strong> {{ $user->email }}</div>
        <div class="mb-2"><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</div>
        <div class="mb-2"><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</div>
        <div class="mb-2"><strong>Vai trò:</strong> {{ $user->role }}</div>
        <div class="mb-2"><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
    </div>
</x-filament-panels::page>

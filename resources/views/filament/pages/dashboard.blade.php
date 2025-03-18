<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // Xác định view tùy chỉnh cho dashboard.
    protected static string $view = 'filament.pages.dashboard';

    // Bạn có thể truyền thêm dữ liệu cho view bằng phương thức mount hoặc các thuộc tính khác.
    public function mount(): void
    {
        // Ví dụ: tính toán thống kê hay lấy dữ liệu cần hiển thị.
    }
}

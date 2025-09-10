<?php

namespace App\Filament\Resources\SliderResource\Pages;

use App\Filament\Resources\SliderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSlider extends CreateRecord
{
    protected static string $resource = SliderResource::class;
    public function getHeading(): string
    {
        return 'Thêm Slider mới';
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('create')
                ->label('Tạo') // 👉 nút chính
                ->submit('create'),

            \Filament\Actions\Action::make('cancel')
                ->label('Hủy') // 👉 nút hủy
                ->url($this->getResource()::getUrl('index')),
        ];
    }
}

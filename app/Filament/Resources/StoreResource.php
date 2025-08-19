<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Grid;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Cửa hàng';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Tên cửa hàng')->required(),
                Textarea::make('address')->label('Địa chỉ')->required(),
                TextInput::make('latitude')->label('Vĩ độ')->numeric()->required(),
                TextInput::make('longitude')->label('Kinh độ')->numeric()->required(),
                TextInput::make('phone')->label('Số điện thoại')->nullable(),
                FileUpload::make('image')->label('Hình ảnh')->disk('public')->directory('stores')->image()->nullable(),
                Toggle::make('is_active')->label('Kích hoạt')->required(),
                Repeater::make('opening_hours')->label('Giờ mở cửa')
                    ->schema([
                        Select::make('day')
                            ->label('Ngày')
                            ->options([
                                'monday' => 'Thứ Hai',
                                'tuesday' => 'Thứ Ba',
                                'wednesday' => 'Thứ Tư',
                                'thursday' => 'Thứ Năm',
                                'friday' => 'Thứ Sáu',
                                'saturday' => 'Thứ Bảy',
                                'sunday' => 'Chủ Nhật',
                            ])
                            ->required(),
                        TimePicker::make('open_time')->label('Giờ mở')->withoutSeconds()->nullable(),
                        TimePicker::make('close_time')->label('Giờ đóng')->withoutSeconds()->nullable(),
                    ])
                    ->columns(3)
                    ->columnSpan(2)
                    ->default([
                        ['day' => 'monday', 'open_time' => '06:00', 'close_time' => '22:00'],
                        ['day' => 'tuesday', 'open_time' => '06:00', 'close_time' => '22:00'],
                        ['day' => 'wednesday', 'open_time' => '06:00', 'close_time' =>  '22:00'],
                        ['day' => 'thursday', 'open_time' => '08:00', 'close_time' => '22:00'],
                        ['day' => 'friday', 'open_time' => '06:00', 'close_time' => '22:00'],
                        ['day' => 'saturday', 'open_time' => '06:00', 'close_time' => '22:00'],
                        ['day' => 'sunday', 'open_time' => '06:00', 'close_time' => '22:00'],
                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên'),
                TextColumn::make('address')->label('Địa chỉ')->limit(50),
                TextColumn::make('latitude')->label('Vĩ độ'),
                TextColumn::make('longitude')->label('Kinh độ'),
                TextColumn::make('is_active')->label('Kích hoạt')->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}

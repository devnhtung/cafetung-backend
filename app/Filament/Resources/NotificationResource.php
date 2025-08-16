<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Filament\Resources\NotificationResource\RelationManagers;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationLabel = 'Thông báo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Tiêu đề')->required(),
                Textarea::make('content')->label('Nội dung')->required()->columnSpan(2),
                FileUpload::make('image')->label('Hình ảnh')->disk('public')->directory('notifications')->image()->nullable(),
                Select::make('recipient')
                    ->label('Người nhận')
                    ->options([
                        'customers' => 'Khách hàng',
                        'employees' => 'Nhân viên',
                        'all' => 'Tất cả',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Tiêu đề'),
                TextColumn::make('content')->label('Nội dung')->limit(50),
                TextColumn::make('image')->label('Hình ảnh'),
                TextColumn::make('recipient')->label('Người nhận'),
                TextColumn::make('published_at')->label('Ngày đăng')->dateTime(),
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'edit' => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
}

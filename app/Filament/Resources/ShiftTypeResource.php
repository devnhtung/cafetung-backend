<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftTypeResource\Pages;
use App\Models\ShiftType;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class ShiftTypeResource extends Resource
{
    protected static ?string $model = ShiftType::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Quản lý loại ca';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Tên loại ca')
                    ->required()
                    ->maxLength(100),
                TimePicker::make('start_time')
                    ->label('Giờ bắt đầu')
                    ->required(),
                TimePicker::make('end_time')
                    ->label('Giờ kết thúc')
                    ->required(),
                TextInput::make('description')
                    ->label('Mô tả')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên loại ca')->searchable(),
                TextColumn::make('start_time')->label('Giờ bắt đầu'),
                TextColumn::make('end_time')->label('Giờ kết thúc'),
                TextColumn::make('description')->label('Mô tả')->limit(50),
            ])
            ->filters([])
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
            'index' => Pages\ListShiftTypes::route('/'),
            'create' => Pages\CreateShiftType::route('/create'),
            'edit' => Pages\EditShiftType::route('/{record}/edit'),
        ];
    }
}
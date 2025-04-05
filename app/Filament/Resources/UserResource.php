<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Quản lý người dùng';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar')->image()->label("avatar")->columnSpan(1),
                TextInput::make('name')
                    ->label('Tên')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true),
                TextInput::make('password')
                    ->label('Mật khẩu')
                    ->password()
                    ->required(fn($record) => $record === null) // Chỉ yêu cầu khi tạo mới
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->minLength(8),
                Select::make('role')
                    ->label('Vai trò')
                    ->options([
                        'customer' => 'Khách hàng',
                        'staff' => 'Nhân viên',
                        'manage' => "Quản lý"
                    ])
                    ->default('customer')
                    ->required(),
                TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->maxLength(20),
                TextInput::make('address')
                    ->label('Địa chỉ')
                    ->columnSpan(2),
                Select::make('position_id')
                    ->relationship('position', 'name')
                    ->label("Vị trí"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')->label('avatar'),
                TextColumn::make('name')->label('Tên')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('role')->label('Vai trò'),
                TextColumn::make('phone')->label('Số điện thoại'),
                TextColumn::make('position')->label('Vị trí'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'customer' => 'Khách hàng',
                        'staff' => 'Nhân viên',
                    ])
                    ->label('Lọc theo vai trò'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeDetailResource\Pages;
use Filament\Forms;
use Filament\Tables;
use App\Models\EmployeeDetail;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Hash;

class EmployeeDetailResource extends Resource
{
    protected static ?string $model = EmployeeDetail::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Quản lý thông tin nhân viên';
    protected $query = null;
    public function __construct()
    {
        $this->query = EmployeeDetail::query()->with('user');
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Thông tin đăng nhập từ bảng users
                Select::make('user_id')
                    ->label('Nhân viên')
                    ->relationship('user', 'name', fn($query) => $query->whereIn('role', ['staff', 'manage']))
                    ->required()
                    ->disabled(fn($record) => $record !== null) // Vô hiệu hóa khi sửa
                    ->dehydrated(true), // Lưu user_id khi tạo mới
                TextInput::make('user.email')
                    ->label('Email')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn($record) => $record?->user?->email),
                FileUpload::make('user.avatar')
                    ->label('Ảnh đại diện')
                    ->image()
                    ->directory('avatars')
                    ->nullable(),
                TextInput::make('new_password')
                    ->label('Mật khẩu mới')
                    ->password()
                    ->minLength(8)
                    ->nullable()
                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null),
                // Thông tin chi tiết nhân viên
                TextInput::make('full_name')
                    ->label('Họ và tên')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date_of_birth')
                    ->label('Ngày sinh')
                    ->nullable(),
                Select::make('gender')
                    ->label('Giới tính')
                    ->options([
                        'male' => 'Nam',
                        'female' => 'Nữ',
                        'other' => 'Khác',
                    ])
                    ->nullable(),
                TextInput::make('phone_number')
                    ->label('Số điện thoại')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('address')
                    ->label('Địa chỉ')
                    ->columnSpan(2)
                    ->nullable(),
                DatePicker::make('hire_date')
                    ->label('Ngày tuyển dụng')
                    ->nullable(),
                TextInput::make('national_id')
                    ->label('CMND/CCCD')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('bank_account')
                    ->label('Tài khoản ngân hàng')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('emergency_contact_name')
                    ->label('Tên người liên hệ khẩn cấp')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('emergency_contact_phone')
                    ->label('Số điện thoại liên hệ khẩn cấp')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('experience')
                    ->label('Kinh nghiệm')
                    ->columnSpan(2)
                    ->nullable(),
                TagsInput::make('skills')
                    ->label('Kỹ năng')
                    ->placeholder('Nhập kỹ năng, ví dụ: Pha chế, Phục vụ')
                    ->nullable(),
                Select::make('status')
                    ->label('Tình trạng')
                    ->options([
                        'active' => 'Đang làm việc',
                        'inactive' => 'Nghỉ việc',
                        'on_leave' => 'Nghỉ phép',
                        'terminated' => 'Chấm dứt hợp đồng',
                    ])
                    ->default('active')
                    ->required(),
                TextInput::make('notes')
                    ->label('Ghi chú')
                    ->columnSpan(2)
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('Họ và tên')->searchable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
                TextColumn::make('phone_number')->label('Số điện thoại'),
                TextColumn::make('status')->label('Tình trạng'),
                TextColumn::make('hire_date')->label('Ngày tuyển dụng')->date(),
                TextColumn::make('skills')->label('Kỹ năng')->formatStateUsing(fn($state) => implode(', ', $state ?? [])),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Đang làm việc',
                        'inactive' => 'Nghỉ việc',
                        'on_leave' => 'Nghỉ phép',
                        'terminated' => 'Chấm dứt hợp đồng',
                    ])
                    ->label('Lọc theo tình trạng'),
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
            'index' => Pages\ListEmployeeDetails::route('/'),
            'create' => Pages\CreateEmployeeDetail::route('/create'),
            'edit' => Pages\EditEmployeeDetail::route('/{record}/edit'),
        ];
    }
}

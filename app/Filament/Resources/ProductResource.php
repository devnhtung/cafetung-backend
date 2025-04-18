<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Grid;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Sản phẩm';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->schema([
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label("Danh mục")
                                    ->required(),
                                TextInput::make('name')->label('tên')->required(),
                                MarkdownEditor::make('description')->label('Mô tả'),
                                TextInput::make('price')->label('giá')->numeric()->required(),
                                Toggle::make('is_available')->label('Hoạt động')->default(true),
                            ])->columnSpan(2),
                        FileUpload::make('image')->image()->label("Hình")->columnSpan(1),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Hình'),
                TextColumn::make('name')->label('Tên')->searchable(),
                TextColumn::make('category.name')->label('Danh mục')->searchable(),
                TextColumn::make('price')->money('vnd')->label('Giá'),
                IconColumn::make('is_available')
                    ->label('Đang bán')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
            ])
            ->searchable()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->defaultPaginationPageOption(25)->extremePaginationLinks();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
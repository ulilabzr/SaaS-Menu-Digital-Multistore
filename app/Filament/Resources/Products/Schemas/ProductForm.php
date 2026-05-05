<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->required()
                    ->reactive()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Select::make('product_category_id')
                    ->label('Kategori Produk')
                    ->required()
                    ->relationship('productCategory', 'name')
                    ->disabled(fn(callable $get) => $get('user_id') === null)
                    ->options(function (callable $get) {
                        $userId = $get('user_id');
                        if ($userId) {
                            return ProductCategory::where('user_id', $userId)->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Select::make('product_category_id')
                    ->label('Kategori Produk')
                    ->required()
                    ->relationship('productCategory', 'name')
                    ->options(function (callable $get) {
                        $userId = $get('user_id');
                        if ($userId) {
                            return ProductCategory::where('user_id', Auth::user()->id)->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->hidden(fn() => Auth::user()->role === 'admin'),
                FileUpload::make('image')
                    ->label('Gambar Menu')
                    ->image()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi Produk')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga Produk')
                    ->numeric()
                    ->required(),
            ]);
    }
}

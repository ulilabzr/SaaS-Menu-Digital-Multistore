<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\ProductCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Nama Toko')
                ->hidden(fn() => Auth::user()->role === 'store'),
                
                TextColumn::make('name')
                ->label('Nama Kategori Menu'),
                
                ImageColumn::make('image')
                ->label('Gambar Menu'),

                TextColumn::make('price')
                ->label('Harga Menu')
                ->money('idr', true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                SelectFilter::make('product_category_id')
                    ->label('Kategori')
                    ->relationship('productCategory', 'name')
                    ->options(function () {
                        if (Auth::user()->role === 'store') {
                            return ProductCategory::where('user_id', Auth::user()->id)->pluck('name', 'id');
                        }
                        return ProductCategory::pluck('name', 'id');
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

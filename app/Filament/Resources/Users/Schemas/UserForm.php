<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->label('Logo Toko')
                    ->image()
                    ->required(),
                    TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                    TextInput::make('username')
                    ->label('Username')
                    ->hint('Username minimal 5 karakter tanpa spasi')
                    ->unique(table: \App\Models\User::class, ignoreRecord: true)
                    ->required(),
                    TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                    TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
                    Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'store' => 'Store'
                    ])
                    ->required(),

            ]);
    }
}

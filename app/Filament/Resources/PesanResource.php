<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanResource\Pages;
use App\Filament\Resources\PesanResource\RelationManagers;
use App\Models\Pesan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesanResource extends Resource
{
    protected static ?string $model = Pesan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('waktu')
                    ->label('Waktu Sholat')
                    ->options([
                        'subuh' => 'Subuh',
                        'dzuhur' => 'Dzuhur',
                        'ashar' => 'Ashar',
                        'maghrib' => 'Maghrib',
                        'isya' => 'Isya',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('pesan_sebelum')
                    ->label('Pesan Sebelum')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('pesan')
                    ->label('Pesan')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('aktif')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('waktu')->label('Waktu Sholat'),
                TextColumn::make('pesan_sebelum')->label('Pesan Sebelum'),
                TextColumn::make('pesan'),
                BooleanColumn::make('aktif')->label('Aktif'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPesans::route('/'),
            'create' => Pages\CreatePesan::route('/create'),
            'edit' => Pages\EditPesan::route('/{record}/edit'),
        ];
    }
}

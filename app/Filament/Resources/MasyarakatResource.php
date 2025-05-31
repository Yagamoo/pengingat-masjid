<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasyarakatResource\Pages;
use App\Filament\Resources\MasyarakatResource\RelationManagers;
use App\Models\Masyarakat;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasyarakatResource extends Resource
{
    protected static ?string $model = Masyarakat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('nama')->label('Nama')->required()->columnSpanFull(),
                Textarea::make('no_hp')->label('Whatsapp')->required()->columnSpanFull(),
                Select::make('gender')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan'
                    ])
                    ->label('Jenis Kelamin')->required(),
                Select::make('id_kabupaten')
                    ->label('Domisili')
                    ->relationship('kabupaten', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama'),
                TextColumn::make('no_hp')->label('Whatsapp'),
                TextColumn::make('gender')->label('Jenis Kelamin'),
                TextColumn::make('kabupaten.nama')->label('Domisili'),
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
            'index' => Pages\ListMasyarakats::route('/'),
            'create' => Pages\CreateMasyarakat::route('/create'),
            'edit' => Pages\EditMasyarakat::route('/{record}/edit'),
        ];
    }
}

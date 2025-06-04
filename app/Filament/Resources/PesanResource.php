<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanResource\Pages;
use App\Filament\Resources\PesanResource\RelationManagers;
use App\Models\Pesan;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Closure;
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
                        'imsak' => 'Imsak',
                        'subuh' => 'Subuh',
                        'terbit' => 'Terbit',
                        'dhuha' => 'Dhuha',
                        'dzuhur' => 'Dzuhur',
                        'ashar' => 'Ashar',
                        'maghrib' => 'Maghrib',
                        'isya' => 'Isya',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $templateSebelum = "Bismillah<br>Assalamu'alaikum,<br>15 menit lagi menuju waktu {$state} untuk wilayah {{lokasi}}<br><br>Jadwal Sholat Hari Ini:<br>Subuh: {{subuh}}<br>Dzuhur: {{dzuhur}}<br>Ashar: {{ashar}}<br>Maghrib: {{maghrib}}<br>Isya: {{isya}}<br><br>Mari kita bersiap untuk menunaikan sholat {$state}<br>Selamat menunaikan ibadah 🤲<br><br>ketik [unlist] untuk berhenti menerima pesan";

                        $templateMasuk = "Bismillah<br>Assalamu'alaikum,<br>Waktu {$state} telah tiba di wilayah {{lokasi}}<br><br>Jadwal Sholat Hari Ini:<br>Subuh: {{subuh}}<br>Dzuhur: {{dzuhur}}<br>Ashar: {{ashar}}<br>Maghrib: {{maghrib}}<br>Isya: {{isya}}<br><br>Mari kita laksanakan sholat {$state}<br>Semoga Allah menerima ibadah kita 🤲<br><br>ketik [unlist] untuk berhenti menerima pesan";

                        $set('pesan_sebelum', $templateSebelum);
                        $set('pesan', $templateMasuk);
                    })
                    ->columnSpanFull(),
                RichEditor::make('pesan_sebelum')
                    ->label('Pesan Sebelum')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Jangan ubah {{lokasi}}, {{subuh}}, {{dzuhur}}, {{ashar}}, {{maghrib}}, {{isya}} sebagai placeholder.')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'bulletList', 'h2', 'h3']),
                    
                RichEditor::make('pesan')
                    ->label('Pesan')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Jangan ubah {{lokasi}}, {{subuh}}, {{dzuhur}}, {{ashar}}, {{maghrib}}, {{isya}} sebagai placeholder.')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'bulletList', 'h2', 'h3']),

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

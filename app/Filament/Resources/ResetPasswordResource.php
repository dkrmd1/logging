<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResetPasswordResource\Pages;
use App\Models\ResetPassword;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;

class ResetPasswordResource extends Resource
{
    protected static ?string $model = ResetPassword::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')->required()->label('Nama'),
            TextInput::make('user_id')->required()->label('User ID'),
            DatePicker::make('tanggal_permohonan')->required()->label('Tanggal Permohonan'),
            TimePicker::make('waktu_permohonan')->required()->label('Jam Permohonan'),
            Select::make('status')
                ->label('Status')
                ->required()
                ->options([
                    'Proses'  => 'Proses',
                    'Selesai' => 'Selesai',
                    'Gagal'   => 'Gagal',
                ]),
            Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(3)
                ->placeholder('Tulis keterangan tambahan...'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->label('Nama'),
                TextColumn::make('user_id')->searchable()->label('User ID'),
                TextColumn::make('tanggal_permohonan')->label('Tanggal')->date()->sortable(),
                TextColumn::make('waktu_permohonan')->label('Jam')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Selesai' => 'success',
                        'Proses'  => 'warning',
                        'Gagal'   => 'danger',
                    }),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
            ])
            ->filters([
                Filter::make('bulan')
                    ->form([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ]),
                        Select::make('tahun')
                            ->label('Tahun')
                            ->options(
                                collect(range(date('Y'), 2020))->mapWithKeys(fn ($y) => [$y => $y])
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['bulan'], fn ($q) => $q->whereMonth('tanggal_permohonan', $data['bulan']))
                            ->when($data['tahun'], fn ($q) => $q->whereYear('tanggal_permohonan', $data['tahun']));
                    }),
            ])
            ->actions([
                ViewAction::make()->label('Lihat'),
                EditAction::make()->label('Edit'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus'),
                ]),
            ])
            ->headerActions([
                Action::make('Export PDF per Tanggal')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->label('Unduh PDF')
                    ->form([
                        DatePicker::make('tanggal_awal')->label('Tanggal Awal')->required(),
                        DatePicker::make('tanggal_akhir')->label('Tanggal Akhir')->required(),
                    ])
                    ->action(function (array $data) {
                        $records = ResetPassword::query()
                            ->whereBetween('tanggal_permohonan', [
                                Carbon::parse($data['tanggal_awal'])->startOfDay(),
                                Carbon::parse($data['tanggal_akhir'])->endOfDay(),
                            ])
                            ->get();

                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.reset-passwords', [
                            'records' => $records,
                            'tanggal_awal' => $data['tanggal_awal'],
                            'tanggal_akhir' => $data['tanggal_akhir'],
                        ]);

                        $filename = 'laporan-reset-password-' . $data['tanggal_awal'] . '_to_' . $data['tanggal_akhir'] . '.pdf';

                        // FIX: Gunakan output() agar PDF tidak kosong saat diunduh
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, $filename);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResetPasswords::route('/'),
            'create' => Pages\CreateResetPassword::route('/create'),
            'edit' => Pages\EditResetPassword::route('/{record}/edit'),
        ];
    }
}

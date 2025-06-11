<?php

namespace App\Filament\Resources\ResetPasswordResource\Pages;

use App\Filament\Resources\ResetPasswordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResetPassword extends EditRecord
{
    protected static string $resource = ResetPasswordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

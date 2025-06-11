<?php

namespace App\Filament\Resources\ResetPasswordResource\Pages;

use App\Filament\Resources\ResetPasswordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResetPassword extends CreateRecord
{
    protected static string $resource = ResetPasswordResource::class;
}

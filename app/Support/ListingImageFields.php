<?php

namespace App\Support;

use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListingImageFields
{
    public static function coverImage(): FileUpload
    {
        return FileUpload::make('cover_image')
            ->label('Cover image')
            ->image()
            ->imagePreviewHeight('200')
            ->directory('listings/cover-images')
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
            ->maxSize(10240)
            ->saveUploadedFileUsing(fn (BaseFileUpload $component, TemporaryUploadedFile $file): string => app(CloudinaryUploader::class)->upload($file, (string) $component->getDirectory()))
            ->getUploadedFileUsing(fn (string $file): array => app(CloudinaryUploader::class)->getUploadedFile($file))
            ->deleteUploadedFileUsing(function (string $file): void {
                app(CloudinaryUploader::class)->delete($file);
            })
            ->columnSpanFull();
    }

    public static function gallery(): FileUpload
    {
        return FileUpload::make('gallery')
            ->label('Gallery')
            ->image()
            ->multiple()
            ->reorderable()
            ->appendFiles()
            ->imagePreviewHeight('160')
            ->directory('listings/gallery')
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
            ->maxFiles(12)
            ->maxSize(10240)
            ->saveUploadedFileUsing(fn (BaseFileUpload $component, TemporaryUploadedFile $file): string => app(CloudinaryUploader::class)->upload($file, (string) $component->getDirectory()))
            ->getUploadedFileUsing(fn (string $file): array => app(CloudinaryUploader::class)->getUploadedFile($file))
            ->deleteUploadedFileUsing(function (string $file): void {
                app(CloudinaryUploader::class)->delete($file);
            })
            ->columnSpanFull();
    }
}

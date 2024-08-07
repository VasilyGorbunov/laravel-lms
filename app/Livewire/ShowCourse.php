<?php

namespace App\Livewire;

use App\Models\Course;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class ShowCourse extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->course->loadCount('episodes');
    }

    public function courseInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->course)
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('title')
                            ->hiddenLabel()
                            ->size('text-4xl')
                            ->weight('font-bold')
                            ->columnSpanFull(),
                        TextEntry::make('tagline')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                        TextEntry::make('instructor.name')
                            ->label('Your teacher')
                            ->columnSpanFull(),
                        Fieldset::make('')
                            ->columns(3)
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('episodes_count')
                                    ->hiddenLabel()
                                    ->formatStateUsing(fn($state) => "$state episodes")
                                    ->icon('heroicon-o-film'),
                                TextEntry::make('formatted_length')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-clock'),
                                TextEntry::make('created_at')
                                    ->hiddenLabel()
                                    ->formatStateUsing(fn($state) => $state->diffForHumans())
                                    ->icon('heroicon-o-calendar'),
                            ])
                            ->extraAttributes(['class' => 'border-none !p-0']),
                    ])->columns(2),
                Section::make('About this course')
                    ->description(fn(Course $record) => $record->description)
                    ->aside()
                    ->schema([
                        RepeatableEntry::make('episodes')
                            ->schema([
                                TextEntry::make('title')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-play-circle'),
                                TextEntry::make('formatted_length')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-clock'),
                            ])
                            ->columns(2)
                    ])
            ]);
    }

    public function render()
    {
        return view('livewire.show-course');
    }
}

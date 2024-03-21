<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Episode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ShowCourse extends Component  implements HasInfolists, HasForms
{

    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->course->loadCount('episodes');
    }

    public function courseInfoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->course)
            ->schema([
                Section::make()->schema([
                    TextEntry::make('title')
                        ->label('')
                        ->size('text-4xl')
                        ->weight('font-bold')
                        ->columnSpanFull(),
                    TextEntry::make('tagline')
                        ->label('')
                        ->columnSpanFull(),
                    TextEntry::make('instructor.name')
                        ->label('Your Teacher')
                        ->columnSpanFull(),


                    Fieldset::make('')
                        ->columns(3)
                        ->columnSpan(1)
                        ->schema([
                            TextEntry::make('episodes_count')
                                ->label('')
                                ->formatStateUsing(fn ($state) => "$state episodes")
                                ->icon('heroicon-o-film'),
                            TextEntry::make('formatted_length')
                                ->label('')
                                ->icon('heroicon-o-clock'),
                            TextEntry::make('created_at')
                                ->date('Y-m-d')
                                ->formatStateUsing(fn ($state) => $state->diffForHumans())
                                ->icon('heroicon-o-calendar'),
                        ])
                    ->extraAttributes(['class' => 'border-none !p-0']),

                    Actions::make([
                        Actions\Action::make('watch')
                            ->label(fn (Course $record) => auth()->user()?->courses->contains($record)
                                ? 'Continue Watching'
                                : 'Start Watching')
                            ->button()
                            ->icon('heroicon-o-play-circle')
                            ->action(fn (Course $record) => $this->redirectRoute('courses.episodes.show', ['course' => $record])),
                    ])
                    ->columnSpanFull(),


                ])->columns(2),
                Section::make('About this course')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('description')
                            ->columnSpan(2),
                        RepeatableEntry::make('episodes')->schema([
                            TextEntry::make('title')
                                ->hiddenLabel()
                                ->icon('heroicon-o-play-circle')
                                ->url(fn (Episode $record) => route('courses.episodes.show', ['course' => $record->course->getRouteKey(), 'episode' => $record->getRouteKey()])),
                            TextEntry::make('formatted_length')
                                ->hiddenLabel()
                                ->icon('heroicon-o-clock'),
                        ])->columns(2),
                    ])
            ]);
    }

    public function render()
    {
        return view('livewire.show-course');
    }


}

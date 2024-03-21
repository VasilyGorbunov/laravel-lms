<?php

namespace App\Livewire;

use App\Infolists\Components\VideoPlayerEntry;
use App\Models\Course;
use App\Models\Episode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Attributes\On;
use Livewire\Component;

class WatchEpisode extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;
    public Episode $currentEpisode;

    public function mount(Course $course, Episode $episode)
    {
        $this->authorize('view', $course);
        $this->course = $course;

        if (isset($episode->id)) {
            $this->currentEpisode = $episode;
        } else {
            $this->currentEpisode = $course->episodes->first();
        }

    }

    public function episodeInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->currentEpisode)
            ->columns(3)
            ->schema([
                Section::make([
                    TextEntry::make('title')
                        ->hiddenLabel()
                        ->size('text-4xl')
                        ->weight('font-bold')
                        ->columnSpan(2),
                    VideoPlayerEntry::make('vimeo_id')
                        ->hiddenLabel()
                        ->columnSpan(2),
                    TextEntry::make('overview')
                        ->columnSpan(2),

                ])->columnSpan(2),
                RepeatableEntry::make('course.episodes')
                    ->hiddenLabel()
                    // ->contained(false)
                    ->schema([
                        TextEntry::make('title')
                            ->hiddenLabel()
                            ->icon(fn (Episode $record) => $record->id === $this->currentEpisode->id ? 'heroicon-s-play-circle' : 'heroicon-o-play-circle')
                            ->iconColor(fn (Episode $record) => $record->id === $this->currentEpisode->id ? 'success' : 'gray')
                            ->weight(fn (Episode $record) => $record->id === $this->currentEpisode->id ? 'font-bold' : 'font-base'),
                        TextEntry::make('formatted_length')
                            ->hiddenLabel()
                            ->icon('heroicon-o-clock'),
                    ])->columns(2),
            ]);
    }

    public function render()
    {
        return view('livewire.watch-episode');
    }

    #[On('episode-ended')]
    public function onEpisodeEnded(Episode $episode)
    {
        $this->currentEpisode = Episode::firstWhere('sort', $episode->sort + 1) ?: $episode;
    }
}

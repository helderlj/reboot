<?php

namespace App\Filament\Resources;

use App\Models\Team;
use Filament\{Forms\Components\BelongsToManyMultiSelect,
    Forms\Components\Card,
    Tables,
    Forms,
    Tables\Filters\MultiSelectFilter};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeamResource\Pages;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Equipe';

    protected static ?string $navigationGroup = "Gerenciar usuários";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make(['default' => 0])
                ->schema([
                    TextInput::make('name')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Nome')
                        ->label('Nome')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

//                    BelongsToManyMultiSelect::make('users')
//                        ->placeholder('Usuários')
//                        ->label('Atribuir Usuários')
//                        ->relationship('users', 'name')
//                        ->columnSpan([
//                            'default' => 12,
//                            'md' => 12,
//                            'lg' => 12,
//                        ]),

                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Criado')
                        ->content(fn(?Team $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Modificado')
                        ->content(fn(?Team $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])
                ->columnSpan(1),
        ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable()
                ->limit(50)
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Criado a partir de'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Criado até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TeamResource\RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}

<?php

namespace App\Filament\Resources\EventResource\Actions;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\StreamedResponse;


class ExportDataAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make('export')
            ->label('Выгрузить данные')
            ->action(function (Model $record = null) {
                $csvHeader = "\xEF\xBB\xBFДата мероприятия;Присутствие (кол-во нажатий);Фамилия;Имя;Отчество;Email;Телефон;Специальность;Место работы;Должность;Город;Очное/онлайн участие;Прибытие на мероприятие;Выдан сертификат\n";
                $csvData = $csvHeader;


                if ($record) {
                    $event = Event::with('users')->find($record->id);

                    foreach ($event->users as $user) {
                        $csvData .= implode(';', self::getData($event, $user)) . "\n";
                    }

                } else {
                    $events = Event::with('users')->get();

                    foreach ($events as $event) {
                        foreach ($event->users as $user) {
                            $csvData .= implode(';', self::getData($event, $user)) . "\n";
                        }
                    }
                }

                $response = new StreamedResponse(function () use ($csvData) {
                    echo $csvData;
                });
                $response->headers->set('Content-Type', 'text/csv');
                $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

                return $response;

            });
    }

    public static function getData($event, $user)
    {
        $cert = Certificate::where('user_id')->where('event_id', $event->id)->first();

        return [
            $event->date_start,
            $user->pivot->count_popup,
            $user->info->surname ?? '',
            $user->info->name ?? '',
            $user->info->patronymic ?? '',
            $user->email ?? '',
            $user->info->phone ?? '',
            $user->info->specialization->title ?? '',
            $user->info->work_place ?? '',
            $user->info->position ?? '',
            $user->info->city ?? '',
            '',
            '',
            (isset($cert) && $cert->is_send) ? 'Да' : 'Нет'
        ];
    }

}

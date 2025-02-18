<?php

namespace App\Services;

use App\Models\ThemeSetting;

class ProgressStatusService
{
    public function getProgressStatusImages(int $key): array
    {
        return $this->getImages($key);
    }

    protected function getImages(int $key): array
    {
        $activeTheme = ThemeSetting::active();
        $tasks = [
            ['Запрос БКИ', 'status01', 2],
            ['Запрос ОКБ', 'status02', 2],
            ['Запрос РС', 'status03', 2],
            ['Скоринг бюро', 'status04', 2],
            ['Запрос ФНС', 'status05', 3, 4],
            ['Запрос в ЕГРН', 'status06', 3, 4],
            ['Запрос недвижимость', 'status07', 3, 4],
            ['Запрос ГИБДД', 'status08', 5],
            ['Запрос ГиМС', 'status09', 5],
            ['Запрос Росгвардия', 'status10', 5],
            ['Запрос Ростехнадзор', 'status11', 5],
            ['Уведомление кредиторов', 'status12', 6],
            ['Подготовка Искового Заявления', 'status13', 6],
            ['Подготовка Списка кредиторов', 'status14', 6],
            ['Подготовка Описи имущества', 'status15', 6],
            ['Подготовка приложений к заявлению', 'status16', 6],
            ['Выписки по лицевым счетам', 'status17', 6],
            ['Отправка Заявления в суд', 'status18', 7],
            ['Заседание в АС', 'status19', 8],
            ['Ознакомление состояния дела в АС', 'status20', 8],
            ['Выбор способа получения', 'status21', 8],
            ['Контроль состояния дела в АС', 'status22', 8],
            ['Завершение процесса в суде', 'status23', 9],
            ['Освобождение от долгов', 'status24', 9]
        ];

        $imagePaths = [];
        foreach ($tasks as $task) {
            $alt = array_shift($task);
            $filename = array_shift($task);
            $thresholds = $task;

            $themeName = $activeTheme->theme_name;
            $notCompletedPath = "images/progress-statuses/$themeName/not_completed/$filename.png";
            $inProgressPath = "images/progress-statuses/$themeName/in_progress/$filename.png";
            $completedPath = "images/progress-statuses/$themeName/completed/$filename.png";

            if ($key < $thresholds[0] || $key == 0) {
                if (!file_exists($notCompletedPath)) {
                    $themeName = 'default';
                }
                $imagePaths[] = "images/progress-statuses/$themeName/not_completed/$filename.png";
            } elseif (($thresholds[1] ?? $thresholds[0]) >= $key) {
                if (!file_exists($inProgressPath)) {
                    $themeName = 'default';
                }
                $imagePaths[] = "images/progress-statuses/$themeName/in_progress/$filename.png";
            } else {
                if (!file_exists($completedPath)) {
                    $themeName = 'default';
                }
                $imagePaths[] = "images/progress-statuses/$themeName/completed/$filename.png";
            }
        }

        return $imagePaths;
    }
}

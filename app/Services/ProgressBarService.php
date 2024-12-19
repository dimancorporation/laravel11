<?php

namespace App\Services;

class ProgressBarService
{
    protected array $progressStyles = [
        500 => ['width' => '0', 'animation' => 'progressAnimationStrike0 6s'],
        2 => ['width' => '16%', 'animation' => 'progressAnimationStrike10 6s'],
        3 => ['width' => '32%', 'animation' => 'progressAnimationStrike23 6s'],
        4 => ['width' => '48%', 'animation' => 'progressAnimationStrike23 6s'],
        5 => ['width' => '64%', 'animation' => 'progressAnimationStrike38 6s'],
        6 => ['width' => '70%', 'animation' => 'progressAnimationStrike58 6s'],
        7 => ['width' => '75%', 'animation' => 'progressAnimationStrike73 6s'],
        8 => ['width' => '80%', 'animation' => 'progressAnimationStrike85 6s'],
        9 => ['width' => '95%', 'animation' => 'progressAnimationStrike95 6s'],
        10 => ['width' => '100%', 'animation' => 'progressAnimationStrike100 6s']
    ];

    public function getProgressBar(int $key): object
    {

        $progressBarAnimation = $this->getProgressBarAnimation($key);
        $progressBarText = $this->getProgressBarWidth($key);

        return (object)[
            'animation' => $progressBarAnimation,
            'width' => $progressBarText,
        ];
    }

    private function getProgressBarAnimation(int $key): string
    {
        return $this->progressStyles[$key]['animation'];
    }

    private function getProgressBarWidth(int $key): string
    {
        return $this->progressStyles[$key]['width'];
    }
}

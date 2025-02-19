<?php

namespace App\Services;

class ProgressBarService
{
    protected array $progressStyles = [
        0 => ['width' => '0%', 'animation' => 'progressAnimationStrike0 0s'],
        1 => ['width' => '0%', 'animation' => 'progressAnimationStrike0 0s'],
        2 => ['width' => '10%', 'animation' => 'progressAnimationStrike10 2s'],
        3 => ['width' => '23%', 'animation' => 'progressAnimationStrike23 3s'],
        4 => ['width' => '23%', 'animation' => 'progressAnimationStrike23 4s'],
        5 => ['width' => '38%', 'animation' => 'progressAnimationStrike38 5s'],
        6 => ['width' => '58%', 'animation' => 'progressAnimationStrike58 6s'],
        7 => ['width' => '73%', 'animation' => 'progressAnimationStrike73 6s'],
        8 => ['width' => '85%', 'animation' => 'progressAnimationStrike85 6s'],
        9 => ['width' => '95%', 'animation' => 'progressAnimationStrike95 6s'],
        10 => ['width' => '100%', 'animation' => 'progressAnimationStrike100 6s'],
        11 => ['width' => '100%', 'animation' => 'progressAnimationStrike100 6s'],
        12 => ['width' => '100%', 'animation' => 'progressAnimationStrike100 6s'],
        13 => ['width' => '100%', 'animation' => 'progressAnimationStrike100 6s'],
    ];

    public function getProgressBar(int $key): array
    {
        $progressBarAnimation = $this->getProgressBarAnimation($key);
        $progressBarText = $this->getProgressBarWidth($key);

        return [
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

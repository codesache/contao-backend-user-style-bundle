<?php

namespace Codesache\BackendUserStyleBundle\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

#[AsHook('parseBackendTemplate')]
class BackendStyleListener
{
    public function __construct(
        private readonly array $cssFiles = [],
        private readonly array $jsFiles = [],
    ) {}

    public function __invoke(string $buffer, string $template): string
    {
        if ($template !== 'be_main') {
            return $buffer;
        }

        if (empty($this->cssFiles) && empty($this->jsFiles)) {
            return $buffer;
        }

        try {
            $user = BackendUser::getInstance();
            if (!$user->id || !$user->enableCustomBackendStyle) {
                return $buffer;
            }
        } catch (\Throwable) {
            return $buffer;
        }

        $css = '';
        foreach ($this->cssFiles as $file) {
            $css .= '<link rel="stylesheet" href="/' . ltrim($file, '/') . '">' . "\n";
        }

        $js = '';
        foreach ($this->jsFiles as $file) {
            $js .= '<script src="/' . ltrim($file, '/') . '"></script>' . "\n";
        }

        if ($css) {
            $buffer = str_replace('</head>', $css . '</head>', $buffer);
        }

        if ($js) {
            $buffer = str_replace('</body>', $js . '</body>', $buffer);
        }

        return $buffer;
    }
}

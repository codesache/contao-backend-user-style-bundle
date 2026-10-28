<?php

namespace Codesache\BackendUserStyleBundle\EventListener\DataContainer;

use Contao\BackendUser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\System;

/**
 * Backend-Inhaltsliste: setzt am .cte_type eine Typ-Klasse „be-type-<typ>“
 * (rowStart → be-type-row-start, rsce_sectionwrapper_start → be-type-rsce-sectionwrapper-start).
 * backend-cs.js kopiert alle „be-“-Klassen als „<klasse>-wrapper“ an die Zeile (.tl_content).
 * Optional wird bei Wrappern das Kategorie-Präfix entfernt: „Grid (Reihe Start)“ → „Reihe Start“.
 */
#[AsCallback(table: 'tl_content', target: 'config.onload')]
class ContentTypeClassListener
{
    private bool $registered = false;

    /**
     * @param string|array<string> $contentTypes 'wrappers' | 'all' | Liste von Elementtypen
     */
    public function __construct(
        private readonly string|array $contentTypes = 'wrappers',
        private readonly bool $stripWrapperGroup = true,
    ) {}

    public function __invoke(): void
    {
        try {
            $user = BackendUser::getInstance();
            if (!$user->id || !$user->enableCustomBackendStyle) {
                return;
            }
        } catch (\Throwable) {
            return;
        }

        // nicht doppelt einhängen (onload läuft je DataContainer)
        if ($this->registered) {
            return;
        }
        $this->registered = true;

        $sorting = &$GLOBALS['TL_DCA']['tl_content']['list']['sorting'];
        $original = $sorting['child_record_callback'] ?? ['tl_content', 'addCteType'];

        $sorting['child_record_callback'] = function (array $row) use ($original): string {
            $html = \is_array($original)
                ? System::importStatic($original[0])->{$original[1]}($row)
                : $original($row);

            return $this->decorate($row['type'], $html);
        };
    }

    private function decorate(string $type, string $html): string
    {
        $isWrapper = $this->isWrapper($type);

        if ($this->matches($type, $isWrapper)) {
            $html = preg_replace('/class="cte_type /', 'class="cte_type be-type-'.$this->toClass($type).' ', $html, 1);
        }

        if ($isWrapper && $this->stripWrapperGroup) {
            $label = $GLOBALS['TL_LANG']['CTE'][$type][0] ?? $type;
            $html = preg_replace('/(<div class="cte_type [^"]*">)[^<]*? \('.preg_quote($label, '/').'\)/', '$1'.$label, $html, 1);
        }

        return $html;
    }

    private function matches(string $type, bool $isWrapper): bool
    {
        return match (true) {
            \is_array($this->contentTypes) => \in_array($type, $this->contentTypes, true),
            'all' === $this->contentTypes => true,
            default => $isWrapper,
        };
    }

    private function isWrapper(string $type): bool
    {
        foreach (['start', 'separator', 'stop'] as $role) {
            if (\in_array($type, $GLOBALS['TL_WRAPPERS'][$role] ?? [], true)) {
                return true;
            }
        }

        return false;
    }

    // rowStart → row-start, rsce_sectionwrapper_start → rsce-sectionwrapper-start
    private function toClass(string $type): string
    {
        return strtolower(str_replace('_', '-', preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $type)));
    }
}

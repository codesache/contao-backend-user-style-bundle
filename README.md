# Contao Backend User Style Bundle

**English** · [Deutsch](#deutsch)

Adds a checkbox to each backend user's profile to individually enable or disable custom CSS and JavaScript in the Contao 5 backend.

## Installation

```bash
composer require codesache/contao-backend-user-style-bundle
```

Run migrations after installation:

```bash
php bin/console contao:migrate
```

## Usage

The bundle ships with its own default backend styles. No configuration is required out of the box.

Each backend user will find a checkbox **„Backend-Anpassungen aktivieren"** in their profile under the *Backend-Theme* section.

## Custom CSS/JS

To use your own files instead of the bundled defaults, add to `config/config.yaml`:

```yaml
codesache_backend_user_style:
    css:
        - files/backend/my-custom.css
    js:
        - files/backend/my-custom.js
```

Paths are relative to the project's `public/` directory.

## Content element type classes

In the content element list (`tl_content`) the bundle adds a type class `be-type-<type>` to
each element's `.cte_type` (camelCase and underscores become hyphens):

| Element type                | Class                                 |
|-----------------------------|---------------------------------------|
| `rowStart`                  | `be-type-row-start`                   |
| `rsce_sectionwrapper_start` | `be-type-rsce-sectionwrapper-start`   |
| `text` (with `all`)         | `be-type-text`                        |

`backend-cs.js` copies every class starting with `be-` to the surrounding row as
`<class>-wrapper` (e.g. `.tl_content.be-type-row-start-wrapper`), so whole rows can be styled.
Contao's own `wrapper_start` / `wrapper_stop` classes on the row stay untouched.

For wrapper elements the category prefix is removed from the label
(„Grid (Reihe Start)“ → „Reihe Start“, „Custom Elements (Section - Anfang)“ → „Section - Anfang“).

Both only apply when the user has enabled the backend customizations. Options:

```yaml
codesache_backend_user_style:
    content_types: wrappers       # wrappers (default) | all | [rowStart, rsce_foo, text]
    strip_wrapper_group: true     # default
```

Wrappers are all types registered in `$GLOBALS['TL_WRAPPERS']` (start/separator/stop),
including RockSolid Custom Elements with a `wrapper` config – new elements need no code change.

Example styling (project CSS, added via the `css` option – the option replaces the defaults,
so list `bundles/codesachebackenduserstyle/backend-cs.css` etc. as well if you still want them):

```css
.tl_content.be-type-row-start-wrapper,
.tl_content.be-type-row-end-wrapper {
  border-left: 4px solid #467da4;
}
```

## Requirements

- PHP 8.2+
- Contao 5.3+

## License

MIT – see [LICENSE](LICENSE)

---

<a id="deutsch"></a>

# Contao Backend User Style Bundle (Deutsch)

[English](#contao-backend-user-style-bundle) · **Deutsch**

Fügt im Profil jedes Backend-Benutzers eine Checkbox hinzu, mit der sich eigenes CSS und JavaScript im Contao-5-Backend pro Benutzer ein- und ausschalten lässt.

## Installation

```bash
composer require codesache/contao-backend-user-style-bundle
```

Nach der Installation die Migrationen ausführen:

```bash
php bin/console contao:migrate
```

## Verwendung

Das Bundle bringt eigene Standard-Styles für das Backend mit. Eine Konfiguration ist dafür nicht nötig.

Jeder Backend-Benutzer findet in seinem Profil im Bereich *Backend-Theme* die Checkbox **„Backend-Anpassungen aktivieren“**.

## Eigenes CSS/JS

Um statt der mitgelieferten Dateien eigene zu laden, in `config/config.yaml` eintragen:

```yaml
codesache_backend_user_style:
    css:
        - files/backend/my-custom.css
    js:
        - files/backend/my-custom.js
```

Die Pfade beziehen sich auf das Verzeichnis `public/` des Projekts.

## Typ-Klassen für Inhaltselemente

In der Liste der Inhaltselemente (`tl_content`) setzt das Bundle am `.cte_type` jedes Elements die Klasse `be-type-<typ>`. Großbuchstaben (camelCase) und Unterstriche werden dabei zu Bindestrichen:

| Elementtyp                  | Klasse                                |
|-----------------------------|---------------------------------------|
| `rowStart`                  | `be-type-row-start`                   |
| `rsce_sectionwrapper_start` | `be-type-rsce-sectionwrapper-start`   |
| `text` (mit `all`)          | `be-type-text`                        |

`backend-cs.js` kopiert jede Klasse, die mit `be-` beginnt, als `<klasse>-wrapper` an die umgebende Zeile (z. B. `.tl_content.be-type-row-start-wrapper`). So lässt sich die ganze Zeile gestalten. Die Contao-eigenen Klassen `wrapper_start` / `wrapper_stop` an der Zeile bleiben unverändert.

Bei Wrapper-Elementen entfällt außerdem das Kategorie-Präfix in der Bezeichnung („Grid (Reihe Start)“ → „Reihe Start“, „Custom Elements (Section - Anfang)“ → „Section - Anfang“).

Beides greift nur, wenn der Benutzer die Backend-Anpassungen aktiviert hat. Optionen:

```yaml
codesache_backend_user_style:
    content_types: wrappers       # wrappers (Standard) | all | [rowStart, rsce_foo, text]
    strip_wrapper_group: true     # Standard
```

Als Wrapper gelten alle Typen, die in `$GLOBALS['TL_WRAPPERS']` registriert sind (start/separator/stop). Dazu gehören auch RockSolid Custom Elements mit `wrapper`-Konfiguration. Neue Elemente brauchen also keine Code-Änderung.

Beispiel für eigenes Styling (Projekt-CSS über die Option `css`; die Option ersetzt die Standarddateien, `bundles/codesachebackenduserstyle/backend-cs.css` usw. also mit aufführen, wenn sie weiter geladen werden sollen):

```css
.tl_content.be-type-row-start-wrapper,
.tl_content.be-type-row-end-wrapper {
  border-left: 4px solid #467da4;
}
```

## Voraussetzungen

- PHP 8.2+
- Contao 5.3+

## Lizenz

MIT – siehe [LICENSE](LICENSE)

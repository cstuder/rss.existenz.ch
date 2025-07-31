# rss.existenz.ch

[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

Handgemachte inoffizielle RSS-Feeds, angeboten von Existenz.ch, implementiert mit [RSS-Bridge](https://rss-bridge.github.io/rss-bridge/)

`LIVE`: <https://rss.existenz.ch>

## Feeds

### MeteoSchweiz Blog

Quelle: <https://www.meteoschweiz.admin.ch/ueber-uns/meteoschweiz-blog.html>

Kein RSS-Feed vorhanden. Der Aufruf der Desktop-Blog-Seite war früher extrem langsam, deshalb wird der Mobile-Feed verwendet. In der Mobile-App gibt es ein [JSON](https://s3-eu-central-1.amazonaws.com/app-prod-static-fra.meteoswiss-app.ch/v1/blog/blog_overview_de.json) welches die aktuelle Artikel auflistet, ab November 2023 sogar mit den effektiven Artikel-URLs.

Im Feed sind nur die Artikel-Anrisse zu lesen.

### Hauptstadt.be

Deprectated: Seit Juli 2025 hat Hauptstadt.be einen eigenen RSS-Feed: <https://www.hauptstadt.be/api/rss-feed>.

Quelle: <https://www.hauptstadt.be>

## Development

- `composer run update-rss-bridge` (Einmalig oder nach Bedarf, z.B. nach der Erstellung einer neuen Bridge. `composer.lock`-Nachricht ignorieren.)
- `composer run serve` -> <http://localhost:8000> bzw. <http://localhost:8000/feeds/> (Trailing Slash ist wichtig)

### Struktur

Das Composer `update-rss-bridge`-Skript lädt die neueste RSS-Bridge-Version herunter und entpackt sie im `public/feeds`-Verzeichnis. Danach werden alle hier entwickelten Bridges aus `src/bridges` per Symlink hinzugefügt. Zusätzlich werden alle Config-Dateien aus `src/config` ins Root-Verzeichnis der RSS-Bridge verlinkt. (Siehe Skript [bin/update-rss-bridge.sh](bin/update-rss-bridge.sh)).

Der Grund für das Ganze Theater ist, dass ich damit eine eigene Index-Seite gestalten kann. Mit dem original RSS-Bridge-Interface bin ich nicht ganz glücklich.

## Deployment

`composer run deploy-LIVE`

### Secrets

GitHub-Secrets werden mit [secrethubwarden](https://github.com/cstuder/secrethubwarden) von Bitwarden synchronisiert.

## Credits

- Hintergrundtextur: [Toptal Subtle Patterns - Light Paper Fibers](https://www.toptal.com/designers/subtlepatterns/light-paper-fibers/)
- RSS-Icon (Favicon & SVG): [EncoderXSolutions](https://www.iconfinder.com/encoderxsolutions) ([Creative Commons Attribution 3.0 Unported](https://creativecommons.org/licenses/by/3.0/))
- Basis-System: [RSS-Bridge](https://rss-bridge.github.io/rss-bridge/)

## Lizenz

Der Code in [diesem Repository](https://github.com/cstuder/rss.existenz.ch) unterliegt der [MIT License](LICENSE).

RSS-Bridge selber unterliegt der [UNLICENSE](https://github.com/RSS-Bridge/rss-bridge/blob/master/UNLICENSE).

## Kontakt

Christian Studer (<cstuder@existenz.ch>), [Bureau für digitale Existenz](https://bureau.existenz.ch)

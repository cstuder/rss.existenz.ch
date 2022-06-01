# rss.existenz.ch

[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

Handgemachte inoffizielle RSS-Feeds, angeboten von Existenz.ch, implementiert mit [RSS-Bridge](https://rss-bridge.github.io/rss-bridge/)

`LIVE`: <https://rss.existenz.ch>

## Feeds

### Hauptstadt.be

Quelle: <https://www.hauptstadt.be>

Kein RSS-Feed vorhanden. Content wird von einem CMS angeliefert, welches auf GraphQL basiert. Request ist kopiert von der aktuellen Index-Seite.

Paywall. Im Feed sind nur die Artikel-Anrisse zu lesen.

### MeteoSchweiz Blog

Quelle: <https://www.meteoschweiz.admin.ch/home/aktuell/meteoschweiz-blog.html>

Folgt irgendwann.

## Development

- `composer run update-rss-bridge` (Einmalig oder nach Bedarf.)
- `composer run serve` -> <http://localhost:8000> bzw. <http://localhost:8000/feeds/> (Trailing Slash ist wichtig)

### Struktur

Das Composer `update-rss-bridge`-Skript lädt die neueste RSS-Bridge-Version herunter und entpackt sie im `public/feeds`-Verzeichnis. Danach werden alle hier entwickelten Bridges aus `src/bridges` per Symlink hinzugefügt. Zusätzlich werden alle Config-Dateien aus `src/config` ins Root-Verzeichnis der RSS-Bridge verlinkt. (Siehe Skript [bin/update-rss-bridge.sh](bin/update-rss-bridge.sh)).

Der Grund für das Ganze Theater ist, dass damit eine eigene Index-Seite gestaltet werden kann. Weil ich nicht ganz glücklich mit dem RSS-Bridge-Interface bin.

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

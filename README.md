# rss.existenz.ch

Handgemachte RSS-Feeds, angeboten von Existenz.ch, implementiert mit [RSS-Bridge](https://rss-bridge.github.io/rss-bridge/)

`LIVE`: <https://rss.existenz.ch>

## Feeds

### Hauptstadt.be

Seite: <https://www.hauptstadt.be>

Kein RSS-Feed vorhanden. Content wird von einem CMS angeliefert, welches auf GraphQL basiert. Request ist kopiert von der aktuellen Index-Seite.

Paywall. Im Feed sind nur die Artikel-Anrisse zu lesen.

### MeteoSchweiz Blog

Seite: <https://www.meteoschweiz.admin.ch/home/aktuell/meteoschweiz-blog.html>

Folgt irgendwann.

## Development

- `composer run update-rss-bridge` (Einmalig oder nach Bedarf.)
- `composer run serve` -> <http://localhost:8000>

### Struktur

Das Composer `update-rss-bridge`-Skript lädt die neueste RSS-Bridge-Version herunter und entpackt sie im `public/feeds`-Verzeichnis. Danach werden alle hier entwickelten Bridges aus `src/bridges` per Symlink hinzugefügt. Zusätzlich werden alle Config-Dateien aus `src/config` ins Root-Verzeichnis der RSS-Bridge verlinkt. (Siehe Skript [bin/update-rss-bridge.sh](bin/update-rss-bridge.sh)).

Der Grund für das Ganze Theater ist, dass damit eine eigene Index-Seite gestaltet werden kann. Weil ich nicht ganz glücklich mit dem RSS-Bridge-Interface bin.

## Deployment

`composer run deploy-LIVE`

### Secrets

GitHub-Secrets werden mit [secrethubwarden](https://github.com/cstuder/secrethubwarden) von Bitwarden synchronisiert.

## Lizenz

Der Code in diesem Repository unterliegt der [MIT License](LICENSE).

RSS-Bridge selber unterliegt der [UNLICENSE](https://github.com/RSS-Bridge/rss-bridge/blob/master/UNLICENSE).

## Kontakt

Christian Studer (<cstuder@existenz.ch>), [Bureau für digitale Existenz](https://bureau.existenz.ch)

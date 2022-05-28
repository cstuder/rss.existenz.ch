#! /usr/bin/env bash
set -o errexit   # abort on nonzero exitstatus
set -o nounset   # abort on unbound variable
set -o pipefail  # don't hide errors within pipes

# Update-Skript
#
# Änderungen an diesem Skript müssen im Deployment-Workflow parallel nachgeführt werden

# Zielverzeichnis leeren
rm -rf public/feeds/*

# RSS-Bridge installieren
composer create-project rss-bridge/rss-bridge public/feeds/ --no-dev

# Symlink bridges und config (Benötigt ein cd damit die Symlinks relativ funktionieren)
cd public/feeds/bridges
ln -s ../../../src/bridges/*.php ./
cd ..
ln -s ../../src/config/* ./

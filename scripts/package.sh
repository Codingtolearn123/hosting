#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
DIST_DIR="$ROOT_DIR/dist"

rm -rf "$DIST_DIR"/*
mkdir -p "$DIST_DIR"

wordpress_bundle=$(mktemp -d)
whmcs_bundle=$(mktemp -d)

pushd "$ROOT_DIR/wordpress" >/dev/null
zip -rq "$wordpress_bundle/VirtualSkyWP.zip" VirtualSkyWP
zip -rq "$wordpress_bundle/virtualsky-ai-assistant.zip" virtualsky-ai-assistant
popd >/dev/null

cp "$ROOT_DIR/README.md" "$wordpress_bundle/README.md"

cp -R "$ROOT_DIR/whmcs/VirtualSky" "$whmcs_bundle/VirtualSky"
mkdir -p "$whmcs_bundle/templates"
mv "$whmcs_bundle/VirtualSky" "$whmcs_bundle/templates/VirtualSky"
cp "$ROOT_DIR/README.md" "$whmcs_bundle/README.md"

pushd "$wordpress_bundle" >/dev/null
zip -rq "$DIST_DIR/VirtualSky_WordPress.zip" README.md VirtualSkyWP.zip virtualsky-ai-assistant.zip
popd >/dev/null

pushd "$whmcs_bundle" >/dev/null
zip -rq "$DIST_DIR/VirtualSky_WHMCS.zip" README.md templates
popd >/dev/null

rm -rf "$wordpress_bundle" "$whmcs_bundle"

echo "Packages generated in $DIST_DIR"

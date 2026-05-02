#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BASE_URL="${1:-http://127.0.0.1:8097}"

cd "${ROOT}"

vendor/bin/drush updb -y
vendor/bin/drush cim -y
vendor/bin/drush cr
vendor/bin/drush config:status --format=table

paths=(
  "/"
  "/products"
  "/commercials"
  "/updates"
  "/friends-family"
  "/find-a-contractor"
  "/find-a-fujitsu-contractor"
  "/why-fujitsu-hawaii"
  "/best-air-conditioning-hawaii"
  "/compare"
  "/find-a-dealer/oahu-dealers"
  "/find-a-dealer/kauai-dealers"
  "/find-a-dealer/big-island-dealers"
  "/find-a-dealer/maui-dealers"
  "/contact/admor_hvac"
  "/contact/athletics_application"
  "/sitemap.xml"
)

for path in "${paths[@]}"; do
  code="$(curl -sS -o /dev/null -w "%{http_code}" "${BASE_URL}${path}")"
  echo "${code} ${path}"
  if [[ "${code}" != "200" ]]; then
    exit 1
  fi
done

redirects=(
  "/category/updates/"
  "/2019/04/20/2014-coolingcancer-charity-golf-tournament/"
)

for path in "${redirects[@]}"; do
  code="$(curl -sS -o /dev/null -w "%{http_code}" -I "${BASE_URL}${path}")"
  echo "${code} ${path}"
  if [[ "${code}" != "301" ]]; then
    exit 1
  fi
done

echo "Launch check passed for ${BASE_URL}"

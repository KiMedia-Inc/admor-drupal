#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
STAMP="$(date +%Y%m%d-%H%M%S)"
DEST="${ROOT}/backups/ilovemyfujitsu-${STAMP}.sql"

mkdir -p "${ROOT}/backups"
cd "${ROOT}"

vendor/bin/drush sql:dump --result-file="${DEST}"
gzip -f "${DEST}"

echo "Database export written to ${DEST}.gz"

#!/bin/bash
# Usage: DB_HOST=localhost DB_USER=user DB_PASS=pass DB_NAME=leohome1_invest ./backup.sh
set -euo pipefail
TS=$(date +%Y%m%d_%H%M%S)
OUT="backup_${DB_NAME}_${TS}.sql.gz"
mysqldump -h"${DB_HOST:-localhost}" -u"${DB_USER:-root}" -p"${DB_PASS:-}" "${DB_NAME}" | gzip > "$OUT"
echo "Backup created: $OUT"
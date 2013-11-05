#!/bin/bash

TESTDIR=$(dirname $0);

CODECOVERAGE=1 \
COVERAGE='--coverage-html '$TESTDIR'/coverage --log-metrics '$TESTDIR'/metrics.xml' \
$TESTDIR/runtests.sh

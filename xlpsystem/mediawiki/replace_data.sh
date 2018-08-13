#!/bin/sh

tar -xvf data.tar ./data
rm -rf /bitnami/
mv data /bitnami

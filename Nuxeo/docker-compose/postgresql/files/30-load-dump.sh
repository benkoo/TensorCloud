#!/bin/bash

for f in /deploy/*; do
	case "$f" in
		*.dump)  
			echo "$0: loading $f"
			gosu postgres pg_restore --clean --if-exists --dbname nuxeo "$f" 
			mv "$f" "$f.loaded"
			;;
		*)     
			echo "$0: ignoring $f" 
			;;
	esac
done
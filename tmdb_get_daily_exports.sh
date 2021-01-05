#!/usr/bin/env bash

mkdir -p tmdb_files
pushd tmdb_files

set -au

formatted_date=$(date +'%m_%d_%Y')

types=(
  movie_ids
  tv_series_ids
  person_ids
  collection_ids
  tv_network_ids
  keyword_ids
  production_company_ids
)

for type in "${types[@]}"
do
  rm "${type}_${formatted_date}.json.gz"
  wget "http://files.tmdb.org/p/exports/${type}_${formatted_date}.json.gz"
done

gzip -f -d *.gz

popd

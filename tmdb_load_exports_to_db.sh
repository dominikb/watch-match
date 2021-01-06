#!/usr/bin/env bash
set -aux

pushd tmdb_files

formatted_date=$(date +'%m_%d_%Y')
function query()
{
  PGPASSWORD=example psql -d postgres -h localhost -p 5432 -U postgres -w -c "${1}"
}

# todo: remove after testing
query 'truncate table collection_ids; truncate table keyword_ids; truncate table movie_ids; truncate person_ids; truncate production_company_ids; truncate tv_network_ids; truncate tv_series_ids;'

sed -i -E 's/\^//g' "movie_ids_${formatted_date}.json"
cat "movie_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|\(.adult)|^\(.original_title)^|\(.video)|\(.popularity)"' > "movie_ids.csv"
docker cp movie_ids.csv watch-match_db_1:/tmp
query "copy movie_ids (id, adult, original_title, video, popularity) from '/tmp/movie_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "tv_series_ids_${formatted_date}.json"
cat "tv_series_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|^\(.original_name)^|\(.popularity)"' > "tv_series_ids.csv"
docker cp tv_series_ids.csv watch-match_db_1:/tmp
query "copy tv_series_ids (id, original_name, popularity) from '/tmp/tv_series_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "collection_ids_${formatted_date}.json"
cat "collection_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|^\(.name)^"' > "collection_ids.csv"
docker cp collection_ids.csv watch-match_db_1:/tmp
query "copy collection_ids (id, name) from '/tmp/collection_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "keyword_ids_${formatted_date}.json"
cat "keyword_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|^\(.name)^"' > "keyword_ids.csv"
docker cp keyword_ids.csv watch-match_db_1:/tmp
query "copy keyword_ids (id, name) from '/tmp/keyword_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "person_ids_${formatted_date}.json"
cat "person_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|\(.adult)|^\(.name)^|\(.popularity)"' > "person_ids.csv"
docker cp person_ids.csv watch-match_db_1:/tmp
query "copy person_ids (id, adult, name, popularity) from '/tmp/person_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "production_company_ids_${formatted_date}.json"
cat "production_company_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|^\(.name)^"' > "production_company_ids.csv"
docker cp production_company_ids.csv watch-match_db_1:/tmp
query "copy production_company_ids (id, name) from '/tmp/production_company_ids.csv' with ( quote '^', delimiter E'|', format csv);"

sed -i -E 's/\^//g' "tv_network_ids_${formatted_date}.json"
cat "tv_network_ids_${formatted_date}.json" \
  | jq -r '"\(.id)|^\(.name)^"' > "tv_network_ids.csv"
docker cp tv_network_ids.csv watch-match_db_1:/tmp
query "copy tv_network_ids (id, name) from '/tmp/tv_network_ids.csv' with ( quote '^', delimiter E'|', format csv);"

popd

SCRIPT="deploy.sh"
DEFAULT_SLUG="laravel-argon"

NAME=${1:-'Laravel Argon'}

LOWER=$(tr '[A-Z]' '[a-z]' <<< $NAME )
UNDER=${LOWER// /_}
SLUG=${UNDER//_/-}

echo "Creating Script to Deploy $NAME under $SLUG...."

cp $SCRIPT $SLUG.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" $SLUG.tmp > $SLUG.sh
rm $SLUG.tmp

echo "Created a Dedicated script for Deployments."

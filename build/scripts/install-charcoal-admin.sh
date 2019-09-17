#!/bin/bash

composer install

./vendor/bin/charcoal admin/tools/copy-assets

echo -n "Do you want to add the admin assets to the project's git repository? "
read gitadd
if [ "$gitadd" == "y" ]; then
    git add www/assets/admin
    git commit -m "Auto-generated admin assets"
    echo -n "Do you want to push the admin assets to remote's git repository? "
    read gitpush
    if [ "$gitpush" == "y" ]; then
        git push
    fi
fi

echo -n "Do you want to add an administrator user? "
read adminadd
if [ "$adminadd" == "y" ]; then
    ./vendor/bin/charcoal admin/user/create
else
    echo -n "You can create a new administrator user later by running \"./vendor/bin/charcoal admin/user/create\""
fi

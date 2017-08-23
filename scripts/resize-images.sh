#!/bin/bash

print_help() {
    echo "# resize-images.sh";
    echo "#   Resize all images in a given directory (recursively) with mogrify.";
    echo "#";
    echo "# USAGE";
    echo "#  resize-images.sh --width=MAX_WIDTH --height=MAX_HEIGHT --dir=DIR";
    echo "#";
    echo "# PARAMETERS";
    echo "#   width:  The maximum width. Defaults to 1920 Ignored if 0.";
    echo "#   height: The maximum height. Defaults to 0. Ignored if 0.";
    echo "#   dir:    The  where to execute the scripts. Defaults to the project's public uploads folder.";
}

while [ $# -gt 0 ]; do
    case "$1" in
        --width=*)
            ARG_MAX_WIDTH="${1#*=}";
            ;;
        --height=*)
            ARG_MAX_HEIGHT="${1#*=}";
            ;;
        --dir=*)
            ARG_DIR="${1#*=}";
            ;;
        --help*)
            print_help;
            exit 0;
            ;;
        *)
          echo "ERROR: Invalid argument \"$1\"";
          exit 1;
  esac
  shift
done

# Set current working dir to public folder (www)
DEFAULT_DIR=$(dirname $0)/../www/uploads;
DIR=${ARG_DIR:-$DEFAULT_DIR};
if [ ! -d "$DIR" ]; then
    echo "ERROR: Invalid directory: \"$DIR\" does not exist.";
    exit 1;
fi;
cd $DIR;

# Ensure the mogrify command exists on system
MOGRIFY_CMD=`command -v mogrify`;
if [ ${#MOGRIFY_CMD} -lt 1 ]; then
    echo "ERROR: The mogrify command was not found on this system.";
    exit 1;
fi

DEFAULT_MAX_WIDTH=1920;
MAX_WIDTH=${ARG_MAX_WIDTH:-$DEFAULT_MAX_WIDTH};

DEFAULT_MAX_HEIGHT=0;
MAX_HEIGHT=${ARG_MAX_HEIGHT:-$DEFAULT_MAX_HEIGHT};

# Resize all images larger than given max width to given max width
if [ $MAX_WIDTH -gt 0 ]; then
    find -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.JPEG" -o -name "*.png" -o -name "*.PNG" \) -exec identify -format "%w %h %i" {} \; | awk '$1 > '$MAX_WIDTH' { sub(/^[^ ]* [^ ]* /, ""); print }' | tr '\n' '\0' | xargs -0  mogrify -resize ${MAX_WIDTH}x;
fi;

if [ $MAX_HEIGHT -gt 0 ]; then
    find -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.JPEG" -o -name "*.png" -o -name "*.PNG" \) -exec identify -format "%w %h %i" {} \; | awk '$2 > '$MAX_HEIGHT' { sub(/^[^ ]* [^ ]* /, ""); print }' | tr '\n' '\0' | xargs -0 mogrify -resize x${MAX_HEIGHT};
 fi;


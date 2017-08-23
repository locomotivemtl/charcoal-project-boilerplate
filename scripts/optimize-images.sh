#!/bin/bash

print_help() {
    echo "# optimize-images.sh";
    echo "# Optimize all images in a given directory (recursively) with jpegoptim and optipng.";
    echo "#";
    echo "# USAGE";
    echo "#   optimize-images.sh --width=MAX_WIDTH --height=MAX_HEIGHT --dir=DIR";
    echo "#";
    echo "# PARAMETERS";
    echo "#   jpg: The jpg quality. Defaults to 85. If 0, then only jpeg stripping will be performed.";
    echo "#   png: The png level. Defaults to 0. Ignored if 0.";
    echo "#   dir: The directory where to execute the scripts. Defaults to the project's public uploads folder.";
}

while [ $# -gt 0 ]; do
    case "$1" in
        --jpg=*)
            ARG_JPG_QUALITY="${1#*=}";
            ;;
        --png=*)
            ARG_PNG_LEVEL="${1#*=}";
            ;;
        --dir=*)
            ARG_DIR="${1#*=}";
            ;;
        --help*)
            print_help;
            exit 0;
            ;;
        *)
          echo "ERROR: Invalid argument \"$1\".";
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

JPEGOPTIM_CMD=`command -v jpegoptim`;
echo ${#JPEGOPTIM_CMD};
if [ ${#JPEGOPTIM_CMD} -lt 1 ]; then
    echo "ERROR: The jpegoptim command was not found on this system.";
    exit 1;
fi

OPTIPNG_CMD=`command -v optipng`;
if [ ${#OPTIPNG_CMD} -lt 1 ]; then
    echo "ERROR: The optipng command was not found on this system.";
    exit 1;
fi;

DEFAULT_JPG_QUALITY=85;
JPG_QUALITY=${ARG_JPG_QUALITY:-$DEFAULT_JPG_QUALITY};

DEFAULT_PNG_LEVEL=5;
PNG_LEVEL=${ARG_PNG_LEVEL:-$DEFAULT_PNG_LEVEL};

# Optimize JPGs to given quality and fix permissions that jpegoptim somehow resets
if [ $JPG_QUALITY -gt 0 ]; then
    find -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.JPEG" \) -exec $JPEGOPTIM_CMD --strip-all --max=$JPG_QUALITY {} \;
else
    find -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.JPEG" \) -exec $JPEGOPTIM_CMD --strip-all {} \;
fi;
find -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.JPEG" \) -exec chmod -R a+r {} \;

# Optimize PNGs to given level
if [ $PNG_LEVEL -gt 0 ]; then
    find -type f \( -name "*.png" -o -name "*.PNG" \) -exec $OPTIPNG_CMD -o$PNG_LEVEL {} \;
fi;

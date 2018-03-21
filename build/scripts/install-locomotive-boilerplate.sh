#!/bin/bash

git clone https://github.com/locomotivemtl/locomotive-boilerplate

rm -rf locomotive-boilerplate/.git

rm locomotive-boilerplate/www/index.html;
rm locomotive-boilerplate/LICENSE;
mv locomotive-boilerplate/README.md locomotive-boilerplate/README-locomotive.md;

cp -Rav locomotive-boilerplate/* .
cp -Rav locomotive-boilerplate/.* .

rm -rf locomotive-boilerplate

ncu -u
npm install

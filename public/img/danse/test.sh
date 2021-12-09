#!/bin/sh

file=$(find -iname '*.jpg' -o -iname '*.jpeg' | sort -n)

nf=$(ls -1 | wc -l)

nf=$((nf-1))

echo $nf
echo $file

for filename in $file
do

    mv $filename exp-$nf.jpg

    ((nf--))


done
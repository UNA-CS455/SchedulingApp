#!/bin/sh

file1="/2018Fall_course_info1.csv"
file2="/2018Fall_course_info2.csv"

diff $file1 $file2 >/dev/null

if $? -eq 1
then
    echo "Same"
else
    echo "Different"
fi

sleep 5s;
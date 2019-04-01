#!/bin/sh

file1="/2018Fall_course_info1.csv"
file2="/2018Fall_course_info2.csv"

if cmp -s "$file1" "$file1"; then
    printf 'The file "%s" is the same as "%s"\n' "$file1" "$file2"
else
    printf 'The file "%s" is different from "%s"\n' "$file1" "$file2"
fi

sleep 5s;
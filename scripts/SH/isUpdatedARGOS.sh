#!/bin/sh

file1="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info1.csv"
file2="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv"

if cmp -s "$file1" "$file2"; then
    printf 'The files are the same! :)'
else
    printf 'The files are different! :('
fi


rename -n 's/C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv/C:/xampp/htdocs/SchedulingApp/fall-info.csv' $file2


sleep 5m;
#!/bin/sh

file1="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info1.csv"
file2="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv"

if cmp -s "$file1" "$file2"; then
    printf 'The files are the same! :)'
    # This will rename the file in your LOCAL copy once you run the file
    # So, check C:/xampp/htdocs/SchedulingApp/ for the file renamed
    mv $file2 'C:/xampp/htdocs/SchedulingApp/2018Fall-info.csv'
else
    printf 'The files are different! :('
fi




sleep 5m;
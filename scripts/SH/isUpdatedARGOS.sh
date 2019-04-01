#!/bin/sh

cmp -s 2018Fall_course_info1.csv 2018Fall_course_info2.csv && echo 'Files are the same' || echo 'Files are different';

sleep 5s;
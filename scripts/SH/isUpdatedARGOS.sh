#!/bin/sh

old="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info1.csv"
new="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv"
# file01="/2018Fall_course_info1.csv"
# file02="/2018Fall_course_info2.csv"

    
#comm may give us what we want
#  -1              suppress column 1 (lines unique to FILE1)
#  -2              suppress column 2 (lines unique to FILE2)
#  -3              suppress column 3 (lines that appear in both files)
#  --check-order   check that the input is correctly sorted, even if all input lines are pairable


#comm -2 -3 <(sort file1) <(sort file2) > file3

unique_to_old="C:/xampp/htdocs/SchedulingApp/unique_to_old.csv"
unique_to_new="C:/xampp/htdocs/SchedulingApp/unique_to_new.csv"
# unique_to_file1="/unique_to_old.csv"
# unique_to_file2="/unique_to_new.csv"

echo 'Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $unique_to_old;
echo 'Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $unique_to_new;
# The parseCSV files need this at the beginning of the file... for reasons unknown


# Need to erase everything that's in the SQL files to ensure no extra data is coming in first
# echo '' >> "uniqueDelete.sql";
# echo '' >> "uniqueInsert.sql"

comm -2 -3 <(sort $old) <(sort $new) > $unique_to_old
comm -1 -3 <(sort $old) <(sort $new) > $unique_to_new


# We need a way to parse through these csv files.. oh wait we have parseCSV.php

# We can change parseCSV.php, or even split into two separate files, to handle
#     inserting and deleting, or even just update the fields that are relevant
#     to the reservations of the given classes.
    
# For now, I think that deleting and inserting reservations all over again
#     would be inefficient, but do we really need to worry about it?
#     It will be running when no one will be using it, so performance will not
#     be noticably impacted. It will also be easier to implement than checking
#     every single reservation for changes and updating all of them. So maybe
#     deleting/inserting would be more efficient than having to search each
#     item?


if [[ -s $unique_to_file1 ]];
then
    echo "File has stuff unique to file 1";
    # mysql -u username –-password=your_password database_name < file.sql 
fi
    
if [[ -s $unique_to_file2 ]]
then
    echo "File has stuff unique to file 2";
    # mysql -u username –-password=your_password database_name < file.sql 
else
    echo "File has no stuff :(";
    # Do nothing
fi



sleep 1m;
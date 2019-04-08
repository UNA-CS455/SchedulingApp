#!/bin/sh

file1="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info1.csv"
file2="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv"

#cmp may not be the thing we want to use, as we need to get what the differences actually are
    #and actually update the database based on what is new
    #If there are any old differences, we need to delete them from the database
    
#comm may give us what we want
#  -1              suppress column 1 (lines unique to FILE1)
#  -2              suppress column 2 (lines unique to FILE2)
#  -3              suppress column 3 (lines that appear in both files)

#  --check-order   check that the input is correctly sorted, even if all input lines are pairable


#comm -2 -3 <(sort file1) <(sort file2) > file3

unique_to_file1="C:/xampp/htdocs/SchedulingApp/unique_to_file1.csv"
unique_to_file1="C:/xampp/htdocs/SchedulingApp/unique_to_file2.csv"

comm -2 -3 <(sort $file1) <(sort $file2) > $unique_to_file1
comm -1 -3 <(sort $file1) <(sort $file2) > $unique_to_file2


#We will need to make a file/function to handle the case where we need to export the differences in the new file to another file
#so that we can easily parse the CSV with the function we have (parseCSV.php), and then insert the new data while deleting any
#old data


#if [[ -s diff.txt ]]; then echo "file has something"; else echo "file is empty"; fi

if [[ -s $result_file ]];
then
    echo "File has stuff :)";
    
else
    echo "File has no stuff :(";
fi



sleep 5m;
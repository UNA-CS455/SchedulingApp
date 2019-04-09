#!/bin/sh

oldFile="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info1.csv"
newFile="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info2.csv"

#cmp may not be the thing we want to use, as we need to get what the differences actually are
    #and actually update the database based on what is new
    #If there are any old differences, we need to delete them from the database
    
#comm may give us what we want
#  -1              suppress column 1 (lines unique to FILE1)
#  -2              suppress column 2 (lines unique to FILE2)
#  -3              suppress column 3 (lines that appear in both files)

#  --check-order   check that the input is correctly sorted, even if all input lines are pairable


#comm -2 -3 <(sort file1) <(sort file2) > file3

unique_to_oldFile="C:/xampp/htdocs/SchedulingApp/unique_to_oldFile.csv"
unique_to_newFile="C:/xampp/htdocs/SchedulingApp/unique_to_newFile.csv"

comm -2 -3 <(sort $oldFile) <(sort $newFile) > $unique_to_oldFile
# comm -2 -3 $file01 $file02 > $unique_to_file1
comm -1 -3 <(sort $oldFile) <(sort $newFile) > $unique_to_newFile


#We will need to make a file/function to handle the case where we need to export the differences in the new file to another file
#so that we can easily parse the CSV with the function we have (parseCSV.php), and then insert the new data while deleting any
#old data


#if [[ -s diff.txt ]]; then echo "file has something"; else echo "file is empty"; fi

if [[ -s $unique_to_oldFile ]]; #We have old data that needs to be deleted
then
    echo "File has stuff unique to the old file";
fi
    
if [[ -s $unique_to_newFile ]]; #We have new data that needs to be inserted
then
    echo "File has stuff unique to the new file";
else
    echo "File has no stuff :(";
fi



sleep 5m;
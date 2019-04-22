#!/bin/sh

# -----------------------------------------------------------------------------------------------
# Things to know beforehand:
#     1) YYYYSemester_course_info.csv holds the course info for that semester of YYYY
#         (for example, 2018Fall_course_info.csv)
# 
#     2) That file is from ARGOS, and is given to the server from ITS
#     3) The current ARGOS file will be named YYYYSemester_course_info_old.csv
# -----------------------------------------------------------------------------------------------
# Flow of the ARGOS auto import, generalized so that it is the same for Server and Local testing
#     1) Recieve the new file from ITS directly into the home directory
#     2) 
#     3)
# 
# -----------------------------------------------------------------------------------------------
# Relevant files:
#   doArgosDelete.php : Handles the deletion of items from the database with a php script
# 
# 
# 
# 


# Server version
# old="/2018Fall_course_info_old.csv"
# new="/2018Fall_course_info.csv"

# Local version
old="C:/xampp/htdocs/SchedulingApp/argos/2018Fall_course_info_old.csv"
new="C:/xampp/htdocs/SchedulingApp/argos/2018Fall_course_info.csv"

# Server version
# unique_to_old="/unique_to_old.csv"
# unique_to_new="/unique_to_new.csv"

# Local version
unique_to_old="C:/xampp/htdocs/SchedulingApp/argos/unique_to_old.csv"
unique_to_new="C:/xampp/htdocs/SchedulingApp/argos/unique_to_new.csv"

#Ensure they exist
touch $unique_to_old
touch $unique_to_new


# For 'comm [OPTION]... FILE1 FILE2'
#  -1              suppress column 1 (lines unique to FILE1)
#  -2              suppress column 2 (lines unique to FILE2)
#  -3              suppress column 3 (lines that appear in both files)
#  --check-order   check that the input is correctly sorted, even if all input lines are pairable

# We may have to remove the () from the sorts when moved into production
# Got conflicting results when tried on the C9 bash environment and a windows environment

comm -2 -3 <(sort $old) <(sort $new) > $unique_to_old # Put items unique to the old version of the class times/locations here
comm -1 -3 <(sort $old) <(sort $new) > $unique_to_new # Put items unique to the new version of the class times/locations here


if [[ -s $unique_to_old ]]; # There were items we need to delete
then
    # Local version
    # uniqueDelete="C:/xampp/htdocs/SchedulingApp/argos/uniqueDelete.csv"
 
    echo "File has stuff unique to old file";
    
    deleteCSV="C:/xampp/htdocs/SchedulingApp/argos/classesToDelete.csv"
    
    # Need the following in the header of the uniqueDelete.csv files for associative array headers
    echo '"Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $deleteCSV;
    cat $unique_to_old >> $deleteCSV
    
    
    # ----------------------------------------------------------------
    
    # Server version
    # argosDeletePath="/figurethisout"
    
    # Local version
    argosDeletePath="C:/xampp/htdocs/SchedulingApp/scripts/PHP/doArgosDelete.php"
    
    # ----------------------------------------------------------------
    deletePHP="C:/xampp/htdocs/SchedulingApp/scripts/PHP/parseCSVdelete.php"
    deleteSQL="C:/xampp/htdocs/SchedulingApp/argos/argosDelete.sql"
    
    
    
    
    
fi
    
if [[ -s $unique_to_new ]]; # There were items we need to add
then
    
    # Local version
    insertCSV="C:/xampp/htdocs/SchedulingApp/argos/classesToInsert.csv"
    
    
    echo "File has stuff unique to new file";
    
    # Need the following in the header of the uniqueInsert.csv files for associative array headers
    echo '"Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $insertCSV;

    # ----------------------------------------------------------------
    
    # Server version
    # argosInsertPath="/figurethisout"
    
    # Local version
    argosInsertPath="C:/xampp/htdocs/SchedulingApp/scripts/PHP/doArgosInsert.php"
    
    # ----------------------------------------------------------------
    
    
    
else
    echo "File has no stuff :(";
    # Do nothing, there were no changes in ARGOS
fi



sleep 1m;
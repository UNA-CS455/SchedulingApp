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
# 
# 
# 


# Server version
# old="/2018Fall_course_info_old.csv"
# new="/2018Fall_course_info.csv"

# Local version
old="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info_old.csv"
new="C:/xampp/htdocs/SchedulingApp/2018Fall_course_info.csv"

# C9 version
# old="/home/ubuntu/workspace/SchedulingApp/2018Fall_course_info_old.csv"
# new="/home/ubuntu/workspace/SchedulingApp/2018Fall_course_info.csv"


# Server version
# unique_to_old="/unique_to_old.csv"
# unique_to_new="/unique_to_new.csv"

# Local version
unique_to_old="C:/xampp/htdocs/SchedulingApp/unique_to_old.csv"
unique_to_new="C:/xampp/htdocs/SchedulingApp/unique_to_new.csv"

# C9 version
# unique_to_old="/home/ubuntu/workspace/SchedulingApp/unique_to_old.csv"
# unique_to_new="/home/ubuntu/workspace/SchedulingApp/unique_to_new.csv"


# For 'comm [OPTION]... FILE1 FILE2'
#  -1              suppress column 1 (lines unique to FILE1)
#  -2              suppress column 2 (lines unique to FILE2)
#  -3              suppress column 3 (lines that appear in both files)
#  --check-order   check that the input is correctly sorted, even if all input lines are pairable


comm -2 -3 <sort $old <sort $new > $unique_to_old
comm -1 -3 <sort $old <sort $new > $unique_to_new


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


if [[ -s $unique_to_old ]]; # There were items we need to delete
then
    echo "File has stuff unique to old file";
    echo '"Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $unique_to_old;
    
    # Server version (These are created here, but used in both parseCSV*.php files)
    # echo '' >> "uniqueDelete.sql";
    
    # Local version
    echo '' >> "C:/xampp/htdocs/SchedulingApp/uniqueDelete.sql";
    
    # C9 version
    # echo '' >> "/home/ubuntu/workspace/SchedulingApp/uniqueDelete.sql";
    
    
    # Hayden computer path
    # echo '' > "E:/xampp/htdocs/SchedulingApp/uniqueDelete.sql";
    
    sh ./argosDelete.sh $unique_to_old "delete"
    
    
    # php parseCSVdelete.php $unique_to_old
    
    # mysql -u root –-password=CSIS455 database_name < "PATH_TO_UNIQUEDELETE/uniqueDelete.sql"
fi
    
if [[ -s $unique_to_new ]]; # There were items we need to add
then
    echo "File has stuff unique to new file";
    echo '"Term Code","Term Description","Full/Part Term Description","Course CRN","Course Subject","Course Number","Course Sequence Number","Building Name","Room Number","Course Start Time","Course End Time","Course Start Date","Course End Date","Sunday Indicator","Monday Indicator","Tuesday Indicator","Wednesday Indicator","Thursday Indicator","Friday Indicator","Saturday Indicator","Course Maximum Enrollment","Course Enrollment"' > $unique_to_new;
    
    # Server version
    # echo '' >> "uniqueDelete.sql";
    
    # Local version
    echo '' >> "C:/xampp/htdocs/SchedulingApp/uniqueInsert.sql";
    
    # C9 version
    # echo '' >> "/home/ubuntu/workspace/SchedulingApp/uniqueInsert.sql";
    
    # php parseCSVinsert.php $unique_to_new
    
    # mysql -u root –-password=CSIS455 database_name < "PATH_TO_UNIQUEINSERT/uniqueInsert.sql"
else
    echo "File has no stuff :(";
    # Do nothing, there were no changes in ARGOS
fi



sleep 1m;
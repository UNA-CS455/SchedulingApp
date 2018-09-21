<?php

class Calendar {  

  /**
  * Constructor
  */
  public function __construct($param)
  {     
    $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    $this->room = $param;
  }

  /********************* PROPERTY ********************/  
  private $dayLabels = array("MON","TUE","WED","THU","FRI","SAT","SUN");

  private $currentYear=0;

  private $currentMonth=0;

  private $currentDay=0;

  private $currentDate=NULL;

  private $daysInMonth=0;

  private $naviHref= NULL;

  private $room = NULL;

  /********************* PUBLIC **********************/  


  /**
  * print out the calendar
  */
  public function show()
  {

    $startYear = date('y');
    $year=$startYear;

    $startMonth = date("m");
    $month = $startMonth;

    $startDay = date("D");
    $day = $startDay;

    if(isset($_GET['year']))
    {
      $year = $_GET['year'];
    }
    else if(NULL==$year)
    {
      $year = date("Y",time());  
    }          

    if(isset($_GET['month']))
    {
      $month = $_GET['month'];
    }
    else if(NULL==$month)
    {
      $month = date("M");
    }                  

    $this->currentYear=intval($year);

    $this->currentMonth=intval($month);

    $this->currentDay=intval($day);

    $this->daysInMonth=$this->_daysInMonth($month,$year);  

    $content='<div class="col-md-9 col-xs-9" id="calendar">'.
      '<div class="box">'.
      $this->_createNavi().
      '</div>'.
      '<div class="box-content">'.
      '<ul class="label">'.$this->_createLabels().'</ul>';   
    $content.='<div class="clear"></div>';     
    $content.='<ul class="dates">';    
     
    $weeksInMonth = $this->_weeksInMonth($month,$year);

    // Create weeks in a month
    for( $i=0; $i<$weeksInMonth; $i++ )
    {
      //Create days in a week
      for($j=1;$j<=7;$j++)
      {
          $content.=$this->_showDay(($i*7+$j));
      }
    }
       
    $content.='</ul>';
     
    $content.='<div class="clear"></div>';     

    $content.='</div>';
         
    $content.='</div>';
    return $content;   
  }

  /********************* PRIVATE **********************/ 
  /**
  * create the li element for ul
  */
  private function _showDay($cellNumber)
  {
    if($this->currentDay==0)
    {
      $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
               
      if(intval($cellNumber) == intval($firstDayOfTheWeek))
      {
        $this->currentDay=1;
      }
    }

    if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) )
    {
      $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
       
      $cellContent = $this->currentDay;
       
      $this->currentDay++;   
    }
    else
    {
      $this->currentDate =NULL;
      $cellContent=NULL;
    }

    $numRes = NULL;

    require "db_conf.php";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error)
    {
      die("Connection failed: " . $conn->connect_error);
    } 

    if ($_GET['room'] == "null")
    {
      $sql = "SELECT COUNT(*) AS total FROM reservations WHERE startdate='$this->currentDate'";
    }
    else
    {
      $sql = "SELECT COUNT(*) AS total FROM reservations WHERE roomnumber='" . $_GET['room'] . "' AND startdate='$this->currentDate'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
      // output data of each row
      while($row = $result->fetch_assoc())
      {
        $numRes = $row['total'];
      }
    }
    $conn->close();

    if($cellContent != null)
    {
      return '<li onclick="calendarDateClicked(this.id)" id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).($cellContent==NULL?'mask':'').'">'. $cellContent. '<br>' . ($numRes==0?'':$numRes . ' Reservation(s)') . '</li>';
    }
    else
    {
      return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).($cellContent==NULL?'mask':'').'">'. $cellContent. '<br>' . ($numRes==0?'':$numRes . ' Reservation(s)') . '</li>';		
    }				
  }

  /**
  * create navigation
  */
  private function _createNavi()
  {
    $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
    $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
    $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
    $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

    return
      '<div class="header">'.
          '<a class="prev" onclick="calendarNavi(' . $preMonth .  ', ' . $preYear . ')">Prev</a>'.
              '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
          '<a class="next" onclick="calendarNavi(' . $nextMonth .  ', ' . $nextYear . ')">Next</a>'.
      '</div>';
  }

  /**
  * create calendar week labels
  */
  private function _createLabels()
  {  
    $content='';

    foreach($this->dayLabels as $index =>$label)
    {
      $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
    }

    return $content;
  }



  /**
  * calculate number of weeks in a particular month
  */
  private function _weeksInMonth($month=NULL,$year=NULL)
  {

    if( NULL==($year) )
    {
      $year =  date("Y",time()); 
    }

    if(NULL==($month))
    {
      $month = date("m",time());
    }

    // find number of days in this month
    $daysInMonths = $this->_daysInMonth($month,$year);
    $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
    $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
    $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
    
    if($monthEndingDay<$monthStartDay)
    {
      $numOfweeks++;
    }

    return $numOfweeks;
  }

  /**
  * calculate number of days in a particular month
  */
  private function _daysInMonth($month=NULL,$year=NULL)
  {
    if(NULL==($year))
      $year =  date("Y",time()); 

    if(NULL==($month))
      $month = date("m",time());
       
    return date('t',strtotime($year.'-'.$month.'-01'));
  }
}

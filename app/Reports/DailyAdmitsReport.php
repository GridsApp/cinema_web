<?php

namespace App\Reports;



class DailyAdmitsReport extends Report
{

    public function query(){

    }


    public function header(){
        $this->addColumn("id" , "ID");
        $this->addColumn("label" , "Label");



       

//        Movie
//        Distributer
//        Type
//        Wk
//        Thu 12-Dec
//        Fri 13-Dec
//        Sat 14-Dec
//        Sun 15-Dec
//        Mon 16-Dec
//        Tue 17-Dec
//        Wed 18-Dec
//        Current
//        Wk
//        Last Wk
//        Life to Date

    }

    public function rows(){


    }

    public function footer(){
        $this->setFooter("id" , 2);
        $this->setFooter("id" , 2);

    }



}

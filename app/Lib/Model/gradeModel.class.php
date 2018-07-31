<?php

class gradeModel extends Model
{
    public function grade_cache() {
        if (false !== F('grade_list')) {
           return F('grade_list');
         }
        else{
            $grades = $this->field("grade,min,max")->order("min asc,id asc")->select();
            $grade_list = array();
            foreach ($grades as $i => $v) {
                $grade_list[$v['grade']]=$v;
            }
            F('grade_list', $grade_list);
        }
        return F('grade_list');
    }

    public function get_grade($exp = 0) {
        $grade_list = $this->grade_cache();
        $grade = 1;
        foreach ($grade_list as $i => $v) {
            if($exp >= $v['min'] && $exp <= $v['max']){
                $grade = $v['grade'];
                break;
            }
        }
        return $grade;
    }

}
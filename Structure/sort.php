<?php


// 冒泡排序 =>  O(n2)
function bubble_sort($nums)
{
    if (count($nums) <= 1) {
        return $nums;
    }

    for ($i = 0; $i < count($nums); $i++) {
        $flag = false;

        for ($j = 0; $j < count($nums) - $i - 1; $j++) {
            $flag = false;
            if ($nums[$j] > $nums[$j+1]) {
                $temp = $nums[$j];
                $nums[$j] = $nums[$j + 1];
                $nums[$j+1] = $temp;
                $flag = true;
            }
        }
        if (!$flag) {
            break;
        }
    }
    return $nums;
}

// 插入排序 =>  O(n2)
function insertion_sort($nums)
{
    if (count($nums) <= 1) {
        return $nums;
    }

    for ($i = 0; $i < count($nums); $i++) { // 浅
        $value = $nums[$i];
        $j = $i - 1;
        for (; $j >= 0; $j--) { // 深
            if ($nums[$j] > $value) {
                $nums[$j+1] = $nums[$j];
            } else {
                break;
            }
        }
        $nums[$j+1] = $value;
    }
    
    return $nums;
}

// 选择排序
function selection_sort($nums) {
    if (count($nums) <= 1) {
        return $nums;
    }

    for ($i =0; $i < count($nums) - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < count($nums); $j++) {
            if ($nums[$j] < $nums[$min]) {
                $min = $j;
            }
        }
        if ($min != $i) {
            $temp = $nums[$i];
            $nums[$i] = $nums[$min];
            $nums[$min] = $temp;
        }
    }

    return $nums;
}


/*
    归并排序
    将数组从中间分开前后两个部分。 然后对前后两部分分别排序
    分治思想
        将一个大问题分解成小都子问题来解决
*/

function merge_sort($nums)
{
    if (count($nums) <= 1) {
        return $nums;
    }

    merge_sort_c($nums, 0, count($nums) -1);
    return $nums;
}


function merge_sort_c(&$nums, $p, $r)
{
    if ($p >= $r) {
        return;
    }


    $q = floor(($p + $r) / 2);

    merge_sort_c($nums, $p, $q);
    merge_sort_c($nums, $q + 1 , $r);


    merge($nums, ['start' => $p, 'end' => $q], ['start' => $q + 1, 'end' => $r]);
}


function merge(&$nums, $nums_p, $nums_q)
{
    $temp = [];

    $i = $nums_p['start'];
    $j = $nums_q['start'];

    $k = 0;

    while($i <= $nums_p['end'] && $j <= $nums_q['end']) {
        if ($nums[$i] <= $nums[$j]) {
            $temp[$k++] = $nums[$i++];
        } else {
            $temp[$k++] = $nums[$j++];
        }
    }

    if ($i <= $nums_p['end']) {
        for (; $i <= $nums_p['end']; $i++) {
            $temp[$k++] = $nums[$i];
        }
    }

    if ($j <= $nums_q['end']) {
        for(; $j <= $nums_q['end']; $j++) {
            $temp[$k++] = $nums[$j];
        }
    }

    for ($x = 0; $x < $k; $x++) {
        $nums[$nums_p['start'] + $x] = $temp[$x];
    }
}



$nums = [4,5,6,3,2,1];
$nums = merge_sort($nums);

print_r($nums);